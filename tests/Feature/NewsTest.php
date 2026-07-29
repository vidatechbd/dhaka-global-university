<?php

use App\Models\News;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
});

test('principal can view news index, create and store news article', function () {
    $principal = User::where('email', 'principal@university.com')->first();

    $this->actingAs($principal)
        ->get(route('admin.news.index'))
        ->assertSuccessful();

    $this->actingAs($principal)
        ->get(route('admin.news.create'))
        ->assertSuccessful();

    $response = $this->actingAs($principal)
        ->post(route('admin.news.store'), [
            'title' => 'Important University Announcement',
            'content' => '<p>This is the official university news announcement.</p>',
            'status' => 'published',
        ]);

    $response->assertRedirect(route('admin.news.index'));
    $this->assertDatabaseHas('news', [
        'title' => 'Important University Announcement',
        'content' => '<p>This is the official university news announcement.</p>',
        'status' => 'published',
        'user_id' => $principal->id,
    ]);
});

test('teacher can view news index, create and store news article with thumbnail', function () {
    $teacher = User::factory()->create(['status' => 'active']);
    $teacher->assignRole('Teacher');

    $this->actingAs($teacher)
        ->get(route('admin.news.index'))
        ->assertSuccessful();

    $this->actingAs($teacher)
        ->get(route('admin.news.create'))
        ->assertSuccessful();

    $file = UploadedFile::fake()->image('thumbnail.jpg', 600, 400);

    $response = $this->actingAs($teacher)
        ->post(route('admin.news.store'), [
            'title' => 'Teacher Announcement',
            'content' => '<p>Class timing will change starting next Monday.</p>',
            'status' => 'draft',
            'thumbnail' => $file,
        ]);

    $response->assertRedirect(route('admin.news.index'));
    
    $article = News::where('title', 'Teacher Announcement')->first();
    expect($article)->not->toBeNull()
        ->and($article->status)->toBe('draft')
        ->and($article->thumbnail)->not->toBeNull();
        
    // Clean up uploaded test thumbnail
    if (file_exists(public_path($article->thumbnail))) {
        unlink(public_path($article->thumbnail));
    }
});

test('student cannot view news index or create news article', function () {
    $student = User::factory()->create(['status' => 'active']);
    $student->assignRole('Student');

    $this->actingAs($student)
        ->get(route('admin.news.index'))
        ->assertForbidden();

    $this->actingAs($student)
        ->get(route('admin.news.create'))
        ->assertForbidden();

    $this->actingAs($student)
        ->post(route('admin.news.store'), [
            'title' => 'Unauthorized Post',
            'content' => 'Content',
            'status' => 'published',
        ])
        ->assertForbidden();
});

test('authorized users can edit, update, and delete news articles', function () {
    $principal = User::where('email', 'principal@university.com')->first();
    $news = News::factory()->create([
        'title' => 'Old Title',
        'content' => 'Old Content',
        'status' => 'draft',
        'user_id' => $principal->id,
    ]);

    $this->actingAs($principal)
        ->get(route('admin.news.edit', $news))
        ->assertSuccessful();

    $response = $this->actingAs($principal)
        ->patch(route('admin.news.update', $news), [
            'title' => 'New Title',
            'content' => 'New Content',
            'status' => 'published',
        ]);

    $response->assertRedirect(route('admin.news.index'));
    $news->refresh();
    expect($news->title)->toBe('New Title')
        ->and($news->content)->toBe('New Content')
        ->and($news->status)->toBe('published');

    $deleteResponse = $this->actingAs($principal)
        ->delete(route('admin.news.destroy', $news));

    $deleteResponse->assertRedirect(route('admin.news.index'));
    $this->assertDatabaseMissing('news', ['id' => $news->id]);
});
