<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class HomepageSettingController extends Controller
{
    /**
     * Display the homepage settings form.
     */
    public function index(): View
    {
        $setting = HomepageSetting::firstOrCreate([]);

        return view('admin.homepage-settings.index', compact('setting'));
    }

    /**
     * Update the homepage settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $setting = HomepageSetting::firstOrCreate([]);

        $validated = $request->validate([
            'show_top_bar' => ['nullable', 'boolean'],
            'top_bar_email' => ['nullable', 'string', 'max:255'],
            'top_bar_phone' => ['nullable', 'string', 'max:255'],
            'top_bar_links' => ['nullable', 'array'],

            'show_hero' => ['nullable', 'boolean'],
            'slides' => ['nullable', 'array'],
            'slides.*.image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],

            'show_about' => ['nullable', 'boolean'],
            'about_tag' => ['nullable', 'string', 'max:255'],
            'about_title' => ['nullable', 'string', 'max:255'],
            'about_description' => ['nullable', 'string'],
            'about_years' => ['nullable', 'string', 'max:255'],
            'about_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'about_url' => ['nullable', 'string', 'max:255'],

            'show_leadership' => ['nullable', 'boolean'],
            'leadership_title' => ['nullable', 'string', 'max:255'],
            'leadership_description' => ['nullable', 'string'],
            'leadership_members' => ['nullable', 'array'],

            'show_faculties' => ['nullable', 'boolean'],
            'faculties_title' => ['nullable', 'string', 'max:255'],
            'faculties_btn_text' => ['nullable', 'string', 'max:255'],
            'faculties_btn_url' => ['nullable', 'string', 'max:255'],
            'faculties' => ['nullable', 'array'],

            'show_news_notice' => ['nullable', 'boolean'],
        ]);

        // Map boolean switches
        $data = [
            'show_top_bar' => $request->has('show_top_bar'),
            'top_bar_email' => $validated['top_bar_email'] ?? null,
            'top_bar_phone' => $validated['top_bar_phone'] ?? null,
            'show_hero' => $request->has('show_hero'),
            'show_about' => $request->has('show_about'),
            'show_leadership' => $request->has('show_leadership'),
            'show_faculties' => $request->has('show_faculties'),
            'show_news_notice' => $request->has('show_news_notice'),
            'about_tag' => $validated['about_tag'] ?? null,
            'about_title' => $validated['about_title'] ?? null,
            'about_description' => $validated['about_description'] ?? null,
            'about_years' => $validated['about_years'] ?? null,
            'about_url' => $validated['about_url'] ?? null,
            'leadership_title' => $validated['leadership_title'] ?? null,
            'leadership_description' => $validated['leadership_description'] ?? null,
            'faculties_title' => $validated['faculties_title'] ?? null,
            'faculties_btn_text' => $validated['faculties_btn_text'] ?? null,
            'faculties_btn_url' => $validated['faculties_btn_url'] ?? null,
        ];

        // Process Top Bar Links
        $topBarLinks = $request->input('top_bar_links', []);
        $processedTopBarLinks = [];
        foreach ($topBarLinks as $link) {
            if (! empty($link['title'])) {
                $processedTopBarLinks[] = [
                    'title' => $link['title'],
                    'url' => $link['url'] ?? '#',
                ];
            }
        }
        $data['top_bar_links'] = $processedTopBarLinks;

        // Process Hero Slides
        $existingSlides = $setting->hero_slides ?? [];
        $processedSlides = [];
        $slidesInput = $request->input('slides', []);

        foreach ($slidesInput as $index => $slide) {
            $existingSlide = $existingSlides[$index] ?? null;
            $imagePath = $existingSlide['image'] ?? null;

            if ($request->hasFile("slides.{$index}.image")) {
                $this->deleteFile($imagePath);
                $file = $request->file("slides.{$index}.image");
                $imagePath = $this->uploadImage($file, 'homepage/hero');
            }

            if ($imagePath || $request->hasFile("slides.{$index}.image")) {
                $processedSlides[] = [
                    'image' => $imagePath,
                    'tag' => $slide['tag'] ?? '',
                    'title' => $slide['title'] ?? '',
                    'description' => $slide['description'] ?? '',
                    'btn_text_1' => $slide['btn_text_1'] ?? '',
                    'btn_url_1' => $slide['btn_url_1'] ?? '',
                    'btn_text_2' => $slide['btn_text_2'] ?? '',
                    'btn_url_2' => $slide['btn_url_2'] ?? '',
                ];
            }
        }

        // Clean up remaining slides on disk if count decreased
        if (count($existingSlides) > count($processedSlides)) {
            for ($i = count($processedSlides); $i < count($existingSlides); $i++) {
                if (isset($existingSlides[$i]['image'])) {
                    $this->deleteFile($existingSlides[$i]['image']);
                }
            }
        }
        $data['hero_slides'] = $processedSlides;

        // Process About Image
        if ($request->hasFile('about_image')) {
            $this->deleteFile($setting->about_image);
            $data['about_image'] = $this->uploadImage($request->file('about_image'), 'homepage/about');
        } else {
            $data['about_image'] = $setting->about_image;
        }

        // Process Leadership Members
        $members = $request->input('leadership_members', []);
        $processedMembers = [];
        foreach ($members as $index => $member) {
            $existingMember = ($setting->leadership_members[$index] ?? null);
            $imagePath = $existingMember['image'] ?? null;

            if ($request->hasFile("leadership_members.{$index}.image")) {
                $this->deleteFile($imagePath);
                $file = $request->file("leadership_members.{$index}.image");
                $imagePath = $this->uploadImage($file, 'homepage/leadership');
            }

            $processedMembers[] = [
                'name' => $member['name'] ?? '',
                'designation' => $member['designation'] ?? '',
                'image' => $imagePath,
                'message_url' => $member['message_url'] ?? '#',
            ];
        }
        $data['leadership_members'] = $processedMembers;

        // Process Faculties
        $faculties = $request->input('faculties', []);
        $processedFaculties = [];
        foreach ($faculties as $index => $faculty) {
            $existingFaculty = ($setting->faculties[$index] ?? null);
            $imagePath = $existingFaculty['image'] ?? null;

            if ($request->hasFile("faculties.{$index}.image")) {
                $this->deleteFile($imagePath);
                $file = $request->file("faculties.{$index}.image");
                $imagePath = $this->uploadImage($file, 'homepage/faculties');
            }

            $processedFaculties[] = [
                'name' => $faculty['name'] ?? '',
                'image' => $imagePath,
                'explore_url' => $faculty['explore_url'] ?? '#',
                'depts' => array_filter(array_map('trim', explode(',', $faculty['depts'] ?? ''))),
            ];
        }
        $data['faculties'] = $processedFaculties;

        $setting->update($data);

        return redirect()->route('admin.homepage-settings.index')
            ->with('success', 'Homepage settings updated successfully.');
    }

    /**
     * Upload helper.
     */
    private function uploadImage($file, string $subDir): string
    {
        $filename = uniqid().'_'.time().'.webp';
        $targetDir = public_path('uploads/'.$subDir);

        if (! File::exists($targetDir)) {
            File::makeDirectory($targetDir, 0755, true);
        }

        $targetPath = $targetDir.'/'.$filename;

        try {
            $manager = new ImageManager(new Driver);
            $image = $manager->read($file->getRealPath());
            $image->toWebp(80)->save($targetPath);

            return 'uploads/'.$subDir.'/'.$filename;
        } catch (\Throwable $e) {
            $file->move($targetDir, $filename);

            return 'uploads/'.$subDir.'/'.$filename;
        }
    }

    /**
     * Delete helper.
     */
    private function deleteFile(?string $path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
