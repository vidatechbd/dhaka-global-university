use App\Models\User;
use App\Models\HomepageSetting;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    $this->artisan('db:seed'); // Seed roles and default settings
});

test('guest cannot access homepage settings page', function () {
    $response = $this->get(route('admin.homepage-settings.index'));
    $response->assertRedirect(route('login'));
});

test('teacher cannot access homepage settings page', function () {
    $teacher = User::factory()->create();
    $teacher->assignRole('Teacher');

    $response = $this->actingAs($teacher)->get(route('admin.homepage-settings.index'));
    $response->assertStatus(403);
});

test('principal can view homepage settings page', function () {
    $principal = User::factory()->create();
    $principal->assignRole('Principal');

    $response = $this->actingAs($principal)->get(route('admin.homepage-settings.index'));
    $response->assertStatus(200);
    $response->assertSee('Hero Section');
});

test('principal can update homepage settings details', function () {
    $principal = User::factory()->create();
    $principal->assignRole('Principal');

    $data = [
        'show_top_bar' => '1',
        'top_bar_email' => 'admin@university.com',
        'top_bar_phone' => '123456789',
        'show_hero' => '1',
        'slides' => [
            [
                'tag' => 'Spring Admissions Open',
                'title' => 'Test Hero Title',
                'description' => 'Test description content',
                'btn_text_1' => 'Apply',
                'btn_url_1' => '#',
            ]
        ],
        'about_title' => 'Test About Title',
        'about_description' => 'Test about description content',
        'show_about' => '1',
    ];

    $response = $this->actingAs($principal)->post(route('admin.homepage-settings.update'), $data);
    $response->assertRedirect(route('admin.homepage-settings.index'));

    $setting = HomepageSetting::first();
    expect($setting->show_top_bar)->toBeTrue()
        ->and($setting->top_bar_email)->toBe('admin@university.com')
        ->and($setting->hero_slides[0]['tag'])->toBe('Spring Admissions Open')
        ->and($setting->hero_slides[0]['title'])->toBe('Test Hero Title')
        ->and($setting->show_hero)->toBeTrue();
});
