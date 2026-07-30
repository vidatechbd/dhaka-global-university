<?php

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

    $response->assertRedirect(route('dashboard'));

    $user = User::where('email', 'john@student.com')->first();
    expect($user->status)->toBe('pending')
        ->and($user->hasRole('Student'))->toBeTrue();

    // Now visit dashboard and assert redirect to pending-approval
    $dashboardResponse = $this->actingAs($user)->get('/dashboard');
    $dashboardResponse->assertRedirect(route('pending-approval'));
});

test('principal can approve pending student', function () {
    $principal = User::where('email', 'principal@university.com')->first();

    $student = User::factory()->create(['status' => 'pending']);
    $student->assignRole('Student');

    $response = $this->actingAs($principal)
        ->patch(route('admin.students.approve', $student));

    $response->assertRedirect();
    $student->refresh();
    expect($student->status)->toBe('active');
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

    $response = $this->actingAs($teacher)
        ->post(route('marksheets.store'), [
            'student_id' => $student->id,
            'title' => 'BSc Computer Science',
            'description' => 'First Class Honors',
        ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('marksheets', [
        'student_id' => $student->id,
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

    $marksheet = \App\Models\Marksheet::create([
        'student_id' => $student->id,
        'title' => 'BSc Computer Science',
        'created_by' => $student->id,
    ]);

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
            'subject' => 'Bachelor of Science in Computer Science',
            'cgpa' => '3.96',
            'out_of' => '4.00',
        ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('certificates', [
        'student_id' => $student->id,
        'name' => 'Jack Nicholson',
        'roll' => '46437',
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

    $certificate = \App\Models\Certificate::create([
        'student_id' => $student->id,
        'name' => 'Jack Nicholson',
        'roll' => '46437',
        'subject' => 'Bachelor of Science in Computer Science',
        'cgpa' => '3.96',
        'out_of' => '4.00',
        'created_by' => $student->id,
    ]);

    $response = $this->get(route('certificates.verify', $certificate));
    $response->assertStatus(200);
    $response->assertSee('Verified Academic Certificate');
});
