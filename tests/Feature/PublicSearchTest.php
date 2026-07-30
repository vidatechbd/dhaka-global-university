use App\Models\News;
use App\Models\Event;
use App\Models\User;

beforeEach(function () {
    $this->artisan('db:seed'); // Seed roles and permissions
});

test('redirects directly to news detail page when exactly 1 news matches', function () {
    $author = User::factory()->create();
    $news = News::factory()->create([
        'title' => 'Unique News Headline 123',
        'status' => 'published',
        'user_id' => $author->id,
    ]);

    $response = $this->get(route('search', ['q' => 'Unique News Headline']));
    $response->assertRedirect(route('news.show', $news));
});

test('redirects directly to event detail page when exactly 1 event matches', function () {
    $author = User::factory()->create();
    $event = Event::factory()->create([
        'title' => 'Unique Event Workshop ABC',
        'status' => 'published',
        'user_id' => $author->id,
    ]);

    $response = $this->get(route('search', ['q' => 'Unique Event Workshop']));
    $response->assertRedirect(route('events.show', $event));
});

test('lists matches on results page when multiple items match search query', function () {
    $author = User::factory()->create();

    $news = News::factory()->create([
        'title' => 'Convocation News Alert',
        'status' => 'published',
        'user_id' => $author->id,
    ]);

    $event = Event::factory()->create([
        'title' => 'Convocation Event Gathering',
        'status' => 'published',
        'user_id' => $author->id,
    ]);

    $response = $this->get(route('search', ['q' => 'Convocation']));
    $response->assertStatus(200);
    $response->assertSee('Convocation News Alert');
    $response->assertSee('Convocation Event Gathering');
});
