use App\Models\User;
use App\Models\Event;

beforeEach(function () {
    $this->artisan('db:seed'); // Seed roles and permissions
});

test('guest cannot access admin events list', function () {
    $response = $this->get(route('admin.events.index'));
    $response->assertRedirect(route('login'));
});

test('teacher can view events list, create and edit events', function () {
    $teacher = User::factory()->create();
    $teacher->assignRole('Teacher');

    $response = $this->actingAs($teacher)->get(route('admin.events.index'));
    $response->assertStatus(200);

    // Create Event
    $data = [
        'title' => 'Web Development Workshop',
        'content' => '<p>Join our workshop</p>',
        'status' => 'published'
    ];

    $response = $this->actingAs($teacher)->post(route('admin.events.store'), $data);
    $response->assertRedirect(route('admin.events.index'));

    $event = Event::where('title', 'Web Development Workshop')->first();
    expect($event)->not->toBeNull()
        ->and($event->slug)->toBe('web-development-workshop')
        ->and($event->status)->toBe('published');

    // Edit Event
    $response = $this->actingAs($teacher)->get(route('admin.events.edit', $event));
    $response->assertStatus(200);

    $updateData = [
        'title' => 'Advanced Workshop',
        'content' => '<p>New workshop content</p>',
        'status' => 'draft'
    ];

    $response = $this->actingAs($teacher)->patch(route('admin.events.update', $event), $updateData);
    $response->assertRedirect(route('admin.events.index'));

    $event->refresh();
    expect($event->title)->toBe('Advanced Workshop')
        ->and($event->status)->toBe('draft');

    // Delete Event
    $response = $this->actingAs($teacher)->delete(route('admin.events.destroy', $event));
    $response->assertRedirect(route('admin.events.index'));
    $this->assertDatabaseMissing('events', ['id' => $event->id]);
});
