<?php

use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;

test('principal can view and update university settings', function () {
    $this->seed(RolesAndPermissionsSeeder::class);

    $principal = User::where('email', 'principal@university.com')->first();

    $this->actingAs($principal)
        ->get(route('admin.settings.index'))
        ->assertSuccessful();

    $response = $this->actingAs($principal)
        ->post(route('admin.settings.update'), [
            'name' => 'Feni Global University',
            'address' => 'Station Road, Feni, Bangladesh',
            'contacts' => [
                ['type' => 'Hotline', 'value' => '+880 1800 000000'],
            ],
            'social_medias' => [
                ['platform' => 'Facebook', 'url' => 'https://facebook.com/feniglobal'],
            ],
            'meta_title' => 'Feni Global University SEO Title',
            'meta_description' => 'Feni Global University description content',
            'meta_keywords' => 'feni, global, university',
            'meta_author' => 'Author Name',
        ]);

    $response->assertRedirect(route('admin.settings.index'));

    $this->assertDatabaseHas('university_settings', [
        'name' => 'Feni Global University',
        'address' => 'Station Road, Feni, Bangladesh',
        'meta_title' => 'Feni Global University SEO Title',
        'meta_description' => 'Feni Global University description content',
        'meta_keywords' => 'feni, global, university',
        'meta_author' => 'Author Name',
    ]);
});
