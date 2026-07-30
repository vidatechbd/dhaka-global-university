<?php

use App\Models\Page;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
});

test('principal can view pages index, create page and store page', function () {
    $principal = User::where('email', 'principal@university.com')->first();

    $this->actingAs($principal)
        ->get(route('admin.pages.index'))
        ->assertSuccessful();

    $this->actingAs($principal)
        ->get(route('admin.pages.create'))
        ->assertSuccessful();

    $response = $this->actingAs($principal)
        ->post(route('admin.pages.store'), [
            'title' => 'About Us',
            'content' => '<p>This is the about page content.</p>',
        ]);

    $response->assertRedirect(route('admin.pages.index'));
    $this->assertDatabaseHas('pages', [
        'title' => 'About Us',
        'slug' => 'about-us',
        'content' => '<p>This is the about page content.</p>',
    ]);
});

test('teacher can view pages index, create page and store page with custom slug', function () {
    $teacher = User::factory()->create(['status' => 'active']);
    $teacher->assignRole('Teacher');

    $this->actingAs($teacher)
        ->get(route('admin.pages.index'))
        ->assertSuccessful();

    $this->actingAs($teacher)
        ->get(route('admin.pages.create'))
        ->assertSuccessful();

    $response = $this->actingAs($teacher)
        ->post(route('admin.pages.store'), [
            'title' => 'Contact Us Info',
            'slug' => 'contact-info',
            'content' => '<p>Contact info here.</p>',
        ]);

    $response->assertRedirect(route('admin.pages.index'));

    $page = Page::where('title', 'Contact Us Info')->first();
    expect($page)->not->toBeNull()
        ->and($page->slug)->toBe('contact-info')
        ->and($page->content)->toBe('<p>Contact info here.</p>');
});

test('student cannot view pages index or create pages', function () {
    $student = User::factory()->create(['status' => 'active']);
    $student->assignRole('Student');

    $this->actingAs($student)
        ->get(route('admin.pages.index'))
        ->assertForbidden();

    $this->actingAs($student)
        ->get(route('admin.pages.create'))
        ->assertForbidden();

    $this->actingAs($student)
        ->post(route('admin.pages.store'), [
            'title' => 'Unauthorized Page',
            'content' => 'Content',
        ])
        ->assertForbidden();
});

test('authorized users can edit, update, and delete pages', function () {
    $principal = User::where('email', 'principal@university.com')->first();
    $page = Page::factory()->create([
        'title' => 'Old Title',
        'slug' => 'old-slug',
        'content' => 'Old Content',
    ]);

    $this->actingAs($principal)
        ->get(route('admin.pages.edit', $page))
        ->assertSuccessful();

    $response = $this->actingAs($principal)
        ->patch(route('admin.pages.update', $page), [
            'title' => 'New Title',
            'slug' => 'new-slug',
            'content' => 'New Content',
        ]);

    $response->assertRedirect(route('admin.pages.index'));
    $page->refresh();
    expect($page->title)->toBe('New Title')
        ->and($page->slug)->toBe('new-slug')
        ->and($page->content)->toBe('New Content');

    $deleteResponse = $this->actingAs($principal)
        ->delete(route('admin.pages.destroy', $page));

    $deleteResponse->assertRedirect(route('admin.pages.index'));
    $this->assertDatabaseMissing('pages', ['id' => $page->id]);
});
