<?php

use App\Models\Marksheet;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
});

test('anyone can verify a marksheet via layout 2 public link', function () {
    $student = User::factory()->create(['status' => 'active']);
    $student->assignRole('Student');

    $marksheet = Marksheet::create([
        'student_id' => $student->id,
        'title' => 'BSc Civil Engineering',
        'student_name' => $student->name,
        'exam_roll' => '172022002',
        'reg_no' => '1502046437',
        'created_by' => $student->id,
        'semesters' => [
            [
                'year' => 'Summer 2019',
                'year_cgp' => '2.65',
                'courses' => [
                    ['code' => 'Math115', 'title' => 'Math-I ( Advance calculus )', 'credit' => '4', 'grade' => 'C+'],
                ],
            ],
        ],
    ]);

    // 1. Get request to verification gate 2
    $response = $this->get(route('marksheets.verify2', $marksheet));
    $response->assertSuccessful();
    $response->assertSee('Academic Verification Gate (PDF Layout)');

    // 2. Post request with incorrect credentials
    $response = $this->post(route('marksheets.verify2', $marksheet), [
        'exam_roll' => 'wrong_roll',
        'reg_no' => 'wrong_reg',
    ]);
    $response->assertSessionHasErrors('verification');

    // 3. Post request with correct credentials
    $response = $this->post(route('marksheets.verify2', $marksheet), [
        'exam_roll' => '172022002',
        'reg_no' => '1502046437',
    ]);
    $response->assertRedirect();

    // 4. Get request after verification session is set
    $response = $this->get(route('marksheets.verify2', $marksheet));
    $response->assertSuccessful();
    $response->assertSee('Dhaka Global University');
    $response->assertSee('Official Academic Transcript');
    $response->assertSee('172022002');
});

test('anyone can search and verify a marksheet via layout 2 verification portal', function () {
    $student = User::factory()->create(['status' => 'active']);
    $student->assignRole('Student');

    $marksheet = Marksheet::create([
        'student_id' => $student->id,
        'title' => 'BSc Civil Engineering',
        'student_name' => $student->name,
        'exam_roll' => '172022002',
        'reg_no' => '1502046437',
        'created_by' => $student->id,
        'semesters' => [
            [
                'year' => 'Summer 2019',
                'year_cgp' => '2.65',
                'courses' => [
                    ['code' => 'Math115', 'title' => 'Math-I ( Advance calculus )', 'credit' => '4', 'grade' => 'C+'],
                ],
            ],
        ],
    ]);

    // 1. Get search form
    $response = $this->get(route('marksheets.verification.form2'));
    $response->assertSuccessful();
    $response->assertSee('Marksheet/Transcript Verification (PDF Layout)');

    // 2. Post search with incorrect credentials
    $response = $this->post(route('marksheets.verification.search2'), [
        'exam_roll' => 'wrong_roll',
        'reg_no' => 'wrong_reg',
    ]);
    $response->assertSessionHasErrors('search');

    // 3. Post search with correct credentials
    $response = $this->post(route('marksheets.verification.search2'), [
        'exam_roll' => '172022002',
        'reg_no' => '1502046437',
    ]);
    $response->assertRedirect(route('marksheets.verify2', $marksheet));

    // 4. Get verification page after redirect
    $response = $this->get(route('marksheets.verify2', $marksheet));
    $response->assertSuccessful();
    $response->assertSee('Official Academic Transcript');
});
