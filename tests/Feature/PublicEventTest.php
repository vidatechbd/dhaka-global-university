use App\Models\Event;
use App\Models\User;

beforeEach(function () {
    $this->artisan('db:seed'); // Seed roles and defaults
});

test('public user can view events index listing', function () {
    $event = Event::factory()->create([
        'title' => 'Exciting seminar program',
        'content' => 'Public content',
        'status' => 'published',
        'user_id' => User::factory()->create()->id
    ]);

    $response = $this->get(route('events.index'));
    $response->assertStatus(200);
    $response->assertSee('Exciting seminar program');
});

test('public user can search events by title or content', function () {
    $author = User::factory()->create();

    Event::factory()->create([
        'title' => 'Important Convocation 2026',
        'content' => 'Graduation ceremony details',
        'status' => 'published',
        'user_id' => $author->id
    ]);

    Event::factory()->create([
        'title' => 'Coding Olympiad Contest',
        'content' => 'Solve programming problems',
        'status' => 'published',
        'user_id' => $author->id
    ]);

    // Search for Convocation
    $response = $this->get(route('events.index', ['q' => 'Convocation']));
    $response->assertStatus(200);
    $response->assertSee('Important Convocation 2026');
    $response->assertDontSee('Coding Olympiad Contest');
});

test('public user can view published event details page', function () {
    $event = Event::factory()->create([
        'title' => 'Public Event Title here',
        'content' => '<p>Special guest details</p>',
        'status' => 'published',
        'user_id' => User::factory()->create()->id
    ]);

    $response = $this->get(route('events.show', $event));
    $response->assertStatus(200);
    $response->assertSee('Public Event Title here');
    $response->assertSee('Special guest details');
});

test('public user cannot view draft event detail', function () {
    $event = Event::factory()->create([
        'title' => 'Draft Event Title',
        'content' => '<p>Draft details</p>',
        'status' => 'draft',
        'user_id' => User::factory()->create()->id
    ]);

    $response = $this->get(route('events.show', $event));
    $response->assertStatus(404);
});
