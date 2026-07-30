use App\Models\News;
use App\Models\User;

beforeEach(function () {
    $this->artisan('db:seed'); // Seed roles and defaults
});

test('public user can view news listing', function () {
    $news = News::factory()->create([
        'title' => 'Exciting news item',
        'content' => 'Public content',
        'status' => 'published',
        'user_id' => User::factory()->create()->id
    ]);

    $response = $this->get(route('news.index'));
    $response->assertStatus(200);
    $response->assertSee('Exciting news item');
});

test('public user can search news by title or content', function () {
    $author = User::factory()->create();
    
    News::factory()->create([
        'title' => 'Important Seminar Notice',
        'content' => 'Content here',
        'status' => 'published',
        'user_id' => $author->id
    ]);

    News::factory()->create([
        'title' => 'Eid Vacation Announcement',
        'content' => 'Vacation content',
        'status' => 'published',
        'user_id' => $author->id
    ]);

    // Search for Notice
    $response = $this->get(route('news.index', ['q' => 'Seminar']));
    $response->assertStatus(200);
    $response->assertSee('Important Seminar Notice');
    $response->assertDontSee('Eid Vacation Announcement');
});

test('public user can view published news detail', function () {
    $news = News::factory()->create([
        'title' => 'Public News Detail Title',
        'content' => '<p>Detail content text</p>',
        'status' => 'published',
        'user_id' => User::factory()->create()->id
    ]);

    $response = $this->get(route('news.show', $news));
    $response->assertStatus(200);
    $response->assertSee('Public News Detail Title');
    $response->assertSee('Detail content text');
});

test('public user cannot view draft news detail', function () {
    $news = News::factory()->create([
        'title' => 'Draft News Detail Title',
        'content' => '<p>Draft content text</p>',
        'status' => 'draft',
        'user_id' => User::factory()->create()->id
    ]);

    $response = $this->get(route('news.show', $news));
    $response->assertStatus(404);
});
