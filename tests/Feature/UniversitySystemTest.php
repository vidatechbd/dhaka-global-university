<?php

use App\Models\Certificate;
use App\Models\Marksheet;
use App\Models\Student;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
});

test('self registered student gets student role and is pending', function () {
    $response = $this->post('/register', [
        'name' => 'John Doe',
        'email' => 'john@student.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]);

    $response->assertRedirect(route('login'));
});

test('principal can approve pending student application', function () {
    $principal = User::where('email', 'principal@university.com')->first();

    // Create admission application first
    $appData = [
        'name' => 'John Admission Student',
        'mobile' => '01812345678',
        'email' => 'john.admission@student.com',
        'program_type' => 'B.Sc in CSE',
        'admission_type' => 'Regular/ Undergraduate',
        'ssc_or_equivalent' => 'SSC Science',
        'ssc_division_or_gpa' => '5.00',
        'hsc_or_equivalent' => 'HSC Science',
        'hsc_division_or_gpa' => '5.00',
    ];
    $this->post('/apply', $appData)->assertRedirect(route('home'));

    $application = Student::where('email', 'john.admission@student.com')->first();
    expect($application)->not->toBeNull()
        ->and($application->status)->toBe('pending');

    // Approve the application
    $response = $this->actingAs($principal)
        ->patch(route('admin.students.approve', $application->id));

    $response->assertRedirect();
    $application->refresh();
    expect($application->status)->toBe('approved');

    // Assert active user account is created with Student role
    $user = User::where('email', 'john.admission@student.com')->first();
    expect($user)->not->toBeNull()
        ->and($user->status)->toBe('active')
        ->and($user->hasRole('Student'))->toBeTrue()
        ->and(Hash::check('password', $user->password))->toBeTrue();
});

test('principal can create teacher account', function () {
    $principal = User::where('email', 'principal@university.com')->first();

    $response = $this->actingAs($principal)
        ->post(route('admin.teachers.store'), [
            'name' => 'Jane Smith',
            'email' => 'jane@teacher.com',
            'password' => 'Password123!',
            'password' => 'Password123!',
        ]);

    $response->assertRedirect();
    $teacher = User::where('email', 'jane@teacher.com')->first();
    expect($teacher->status)->toBe('active')
        ->and($teacher->hasRole('Teacher'))->toBeTrue();
});

test('teacher can issue marksheet to active student', function () {
    $teacher = User::factory()->create(['status' => 'active']);
    $teacher->assignRole('Teacher');

    $student = User::factory()->create(['status' => 'active']);
    $student->assignRole('Student');

    $semestersData = [
        [
            'year' => '1ST YEAR',
            'year_cgp' => '3.85',
            'courses' => [
                ['code' => 'CSE101', 'title' => 'Introduction to Computer Science', 'credit' => '3', 'grade' => 'A'],
            ],
        ],
    ];

    $response = $this->actingAs($teacher)
        ->post(route('marksheets.store'), [
            'student_id' => $student->id,
            'student_name' => $student->name,
            'title' => 'BSc Computer Science',
            'description' => 'First Class Honors',
            'semesters' => json_encode($semestersData),
        ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('marksheets', [
        'student_id' => $student->id,
        'student_name' => $student->name,
        'title' => 'BSc Computer Science',
        'created_by' => $teacher->id,
    ]);

    $marksheet = Marksheet::where('student_id', $student->id)->first();
    $this->assertNotNull($marksheet->semesters);
    expect($marksheet->semesters[0]['year'])->toBe('1ST YEAR');
    expect($marksheet->semesters[0]['year_cgp'])->toBe('3.85');

    // Verify it renders correctly on show view
    $showResponse = $this->actingAs($student)->get(route('marksheets.show', $marksheet));
    $showResponse->assertStatus(200);
    $showResponse->assertSee('YEAR');
    $showResponse->assertSee('YEAR CGP');
    $showResponse->assertSee('1ST YEAR');
    $showResponse->assertSee('3.85');
});

test('teacher can issue marksheet without student record (custom name)', function () {
    $teacher = User::factory()->create(['status' => 'active']);
    $teacher->assignRole('Teacher');

    $response = $this->actingAs($teacher)
        ->post(route('marksheets.store'), [
            'student_id' => null,
            'student_name' => 'Custom Student Name',
            'title' => 'BSc Computer Science',
            'description' => 'First Class Honors',
        ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('marksheets', [
        'student_id' => null,
        'student_name' => 'Custom Student Name',
        'title' => 'BSc Computer Science',
        'created_by' => $teacher->id,
    ]);
});

test('teacher or principal can access marksheet generation page', function () {
    $teacher = User::factory()->create(['status' => 'active']);
    $teacher->assignRole('Teacher');

    $response = $this->actingAs($teacher)->get(route('marksheets.create'));
    $response->assertStatus(200);
});

test('student cannot access marksheet generation page', function () {
    $student = User::factory()->create(['status' => 'active']);
    $student->assignRole('Student');

    $response = $this->actingAs($student)->get(route('marksheets.create'));
    $response->assertStatus(403);
});

test('anyone can verify a marksheet via public link', function () {
    $student = User::factory()->create(['status' => 'active']);
    $student->assignRole('Student');

    $marksheet = Marksheet::create([
        'student_id' => $student->id,
        'title' => 'BSc Computer Science',
        'exam_roll' => '46437',
        'reg_no' => '1502046437',
        'created_by' => $student->id,
    ]);

    $response = $this->get(route('marksheets.verify', $marksheet));
    $response->assertStatus(200);
    $response->assertSee('Verify Academic Transcript');

    $response = $this->post(route('marksheets.verify', $marksheet), [
        'exam_roll' => 'wrong',
        'reg_no' => 'wrong',
    ]);
    $response->assertSessionHasErrors('verification');

    $response = $this->post(route('marksheets.verify', $marksheet), [
        'exam_roll' => '46437',
        'reg_no' => '1502046437',
    ]);
    $response->assertRedirect();

    $response = $this->get(route('marksheets.verify', $marksheet));
    $response->assertStatus(200);
    $response->assertSee('Verified Academic Document');
});

test('teacher can issue certificate to active student', function () {
    $teacher = User::factory()->create(['status' => 'active']);
    $teacher->assignRole('Teacher');

    $student = User::factory()->create(['status' => 'active']);
    $student->assignRole('Student');

    $response = $this->actingAs($teacher)
        ->post(route('certificates.store'), [
            'student_id' => $student->id,
            'name' => 'Jack Nicholson',
            'roll' => '46437',
            'reg_no' => '1502046437',
            'subject' => 'Bachelor of Science in Computer Science',
            'cgpa' => '3.96',
            'out_of' => '4.00',
        ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('certificates', [
        'student_id' => $student->id,
        'name' => 'Jack Nicholson',
        'roll' => '46437',
        'reg_no' => '1502046437',
        'created_by' => $teacher->id,
    ]);
});

test('teacher or principal can access certificate generation page', function () {
    $teacher = User::factory()->create(['status' => 'active']);
    $teacher->assignRole('Teacher');

    $response = $this->actingAs($teacher)->get(route('certificates.create'));
    $response->assertStatus(200);
});

test('student cannot access certificate generation page', function () {
    $student = User::factory()->create(['status' => 'active']);
    $student->assignRole('Student');

    $response = $this->actingAs($student)->get(route('certificates.create'));
    $response->assertStatus(403);
});

test('anyone can verify a certificate via public link', function () {
    $student = User::factory()->create(['status' => 'active']);
    $student->assignRole('Student');

    $certificate = Certificate::create([
        'student_id' => $student->id,
        'name' => 'Jack Nicholson',
        'roll' => '46437',
        'reg_no' => '1502046437',
        'subject' => 'Bachelor of Science in Computer Science',
        'cgpa' => '3.96',
        'out_of' => '4.00',
        'created_by' => $student->id,
    ]);

    $response = $this->get(route('certificates.verify', $certificate));
    $response->assertStatus(200);
    $response->assertSee('Verify Academic Certificate');

    $response = $this->post(route('certificates.verify', $certificate), [
        'roll' => 'wrong',
        'reg_no' => 'wrong',
    ]);
    $response->assertSessionHasErrors('verification');

    $response = $this->post(route('certificates.verify', $certificate), [
        'roll' => '46437',
        'reg_no' => '1502046437',
    ]);
    $response->assertRedirect();

    $response = $this->get(route('certificates.verify', $certificate));
    $response->assertStatus(200);
    $response->assertSee('Verified Academic Certificate');
});
