use App\Models\User;
use App\Models\Sidebar;
use App\Models\Page;

beforeEach(function () {
    $this->artisan('db:seed'); // Seed roles and permissions
});

test('guest cannot access sidebars list', function () {
    $response = $this->get(route('admin.sidebars.index'));
    $response->assertRedirect(route('login'));
});

test('teacher can view sidebars and create sidebar', function () {
    $teacher = User::factory()->create();
    $teacher->assignRole('Teacher');

    $response = $this->actingAs($teacher)->get(route('admin.sidebars.index'));
    $response->assertStatus(200);

    $data = [
        'name' => 'Admissions Sidebar',
        'contents' => [
            [
                'title' => 'HTML Block',
                'type' => 'html',
                'content' => '<p>Welcome</p>',
                'sort_order' => 0
            ],
            [
                'title' => 'Links Block',
                'type' => 'links',
                'link_titles' => ['Apply Now', 'Fees'],
                'link_urls' => ['/apply', '/fees'],
                'sort_order' => 1
            ]
        ]
    ];

    $response = $this->actingAs($teacher)->post(route('admin.sidebars.store'), $data);
    $response->assertRedirect(route('admin.sidebars.index'));

    $sidebar = Sidebar::first();
    expect($sidebar->name)->toBe('Admissions Sidebar')
        ->and($sidebar->contents)->toHaveCount(2);

    $linksWidget = $sidebar->contents()->where('type', 'links')->first();
    expect(json_decode($linksWidget->content, true))->toHaveCount(2);
});

test('authorized users can save parent page for a page', function () {
    $teacher = User::factory()->create();
    $teacher->assignRole('Teacher');

    $parentPage = Page::create([
        'title' => 'About Us',
        'slug' => 'about-us',
        'content' => 'About us description'
    ]);

    $data = [
        'title' => 'History',
        'slug' => 'history',
        'content' => 'Our history description',
        'parent_id' => $parentPage->id,
    ];

    $response = $this->actingAs($teacher)->post(route('admin.pages.store'), $data);
    $response->assertRedirect(route('admin.pages.index'));

    $childPage = Page::where('slug', 'history')->first();
    expect($childPage->parent_id)->toBe($parentPage->id);
});
