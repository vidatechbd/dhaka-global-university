use App\Models\Student;

test('public user can view apply page', function () {
    $response = $this->get(route('apply'));
    $response->assertStatus(200);
});

test('public user can submit online admission application', function () {
    $response = $this->post(route('apply'), [
        'name' => 'Faisal Rahman',
        'mobile' => '01912345678',
        'email' => 'faisal@example.com',
        'program_type' => 'B.Sc in CSE',
        'admission_type' => 'Regular/ Undergraduate',
        'ssc_or_equivalent' => 'SSC Science',
        'ssc_division_or_gpa' => '5.00',
        'hsc_or_equivalent' => 'HSC Science',
        'hsc_division_or_gpa' => '4.80',
    ]);

    $response->assertRedirect(route('home'));
    $this->assertDatabaseHas('students', [
        'name' => 'Faisal Rahman',
        'email' => 'faisal@example.com',
        'status' => 'pending',
    ]);
});

test('submitting application with invalid mobile length fails validation', function () {
    $response = $this->post(route('apply'), [
        'name' => 'Faisal Rahman',
        'mobile' => '12345', // invalid length (must be 11)
        'email' => 'faisal@example.com',
        'program_type' => 'B.Sc in CSE',
        'admission_type' => 'Regular/ Undergraduate',
        'ssc_or_equivalent' => 'SSC Science',
        'ssc_division_or_gpa' => '5.00',
        'hsc_or_equivalent' => 'HSC Science',
        'hsc_division_or_gpa' => '4.80',
    ]);

    $response->assertSessionHasErrors('mobile');
    $this->assertDatabaseCount('students', 0);
});

test('submitting application with non-numeric mobile fails validation', function () {
    $response = $this->post(route('apply'), [
        'name' => 'Faisal Rahman',
        'mobile' => 'Nobis praes', // non-numeric but 11 chars
        'email' => 'faisal@example.com',
        'program_type' => 'B.Sc in CSE',
        'admission_type' => 'Regular/ Undergraduate',
        'ssc_or_equivalent' => 'SSC Science',
        'ssc_division_or_gpa' => '5.00',
        'hsc_or_equivalent' => 'HSC Science',
        'hsc_division_or_gpa' => '4.80',
    ]);

    $response->assertSessionHasErrors('mobile');
    $this->assertDatabaseCount('students', 0);
});
