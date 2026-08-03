<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UniversitySetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class UniversitySettingController extends Controller
{
    /**
     * Display the settings form.
     */
    public function index(): View
    {
        $setting = UniversitySetting::firstOrCreate(
            [],
            [
                'name' => 'Dhaka Global University',
                'address' => 'Purbachal Model Town, Uttara, Dhaka, Bangladesh',
                'contacts' => [
                    ['type' => 'Phone', 'value' => '+880 1234 567890'],
                    ['type' => 'Email', 'value' => 'contact@dhakaglobal.university'],
                ],
                'social_medias' => [
                    ['platform' => 'Facebook', 'url' => 'https://facebook.com'],
                    ['platform' => 'Twitter', 'url' => 'https://twitter.com'],
                    ['platform' => 'LinkedIn', 'url' => 'https://linkedin.com'],
                ],
            ]
        );

        return view('admin.settings.index', compact('setting'));
    }

    /**
     * Update the university settings in storage.
     */
    public function update(Request $request): RedirectResponse
    {
        $setting = UniversitySetting::firstOrCreate([]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'contacts' => ['nullable', 'array'],
            'social_medias' => ['nullable', 'array'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'controller_of_examinations' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'marksheet_prepared_by' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'marksheet_compared_by' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'marksheet_controller_signature' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
            'meta_author' => ['nullable', 'string', 'max:255'],
            'favicon' => ['nullable', 'file', 'mimes:ico,png,jpg,jpeg,gif,webp', 'max:1024'],
            'established_year' => ['nullable', 'string', 'max:10'],
        ]);

        // established_year is saved directly to its own column — no contacts merging needed

        if ($request->hasFile('logo')) {
            if ($setting->logo && File::exists(public_path($setting->logo))) {
                File::delete(public_path($setting->logo));
            }

            $file = $request->file('logo');
            $filename = 'logo_'.time().'.webp';
            $targetDir = public_path('uploads/settings');

            if (! File::exists($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }

            $targetPath = $targetDir.'/'.$filename;

            try {
                $manager = new ImageManager(new Driver);
                $image = $manager->read($file->getRealPath());
                $image->toWebp(80)->save($targetPath);
                $validated['logo'] = 'uploads/settings/'.$filename;
            } catch (\Throwable $e) {
                $file->move($targetDir, $filename);
                $validated['logo'] = 'uploads/settings/'.$filename;
            }
        }

        if ($request->hasFile('controller_of_examinations')) {
            if ($setting->controller_of_examinations && File::exists(public_path($setting->controller_of_examinations))) {
                File::delete(public_path($setting->controller_of_examinations));
            }

            $file = $request->file('controller_of_examinations');
            $filename = 'controller_of_examinations_'.time().'.png';
            $targetDir = public_path('uploads/settings');

            if (! File::exists($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }

            $targetPath = $targetDir.'/'.$filename;

            try {
                $manager = new ImageManager(new Driver);
                $image = $manager->read($file->getRealPath());
                $image->toPng()->save($targetPath);
                $validated['controller_of_examinations'] = 'uploads/settings/'.$filename;
            } catch (\Throwable $e) {
                $file->move($targetDir, $filename);
                $validated['controller_of_examinations'] = 'uploads/settings/'.$filename;
            }
        }

        if ($request->hasFile('marksheet_prepared_by')) {
            if ($setting->marksheet_prepared_by && File::exists(public_path($setting->marksheet_prepared_by))) {
                File::delete(public_path($setting->marksheet_prepared_by));
            }

            $file = $request->file('marksheet_prepared_by');
            $filename = 'marksheet_prepared_by_'.time().'.png';
            $targetDir = public_path('uploads/settings');

            if (! File::exists($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }

            $targetPath = $targetDir.'/'.$filename;

            try {
                $manager = new ImageManager(new Driver);
                $image = $manager->read($file->getRealPath());
                $image->toPng()->save($targetPath);
                $validated['marksheet_prepared_by'] = 'uploads/settings/'.$filename;
            } catch (\Throwable $e) {
                $file->move($targetDir, $filename);
                $validated['marksheet_prepared_by'] = 'uploads/settings/'.$filename;
            }
        }

        if ($request->hasFile('marksheet_compared_by')) {
            if ($setting->marksheet_compared_by && File::exists(public_path($setting->marksheet_compared_by))) {
                File::delete(public_path($setting->marksheet_compared_by));
            }

            $file = $request->file('marksheet_compared_by');
            $filename = 'marksheet_compared_by_'.time().'.png';
            $targetDir = public_path('uploads/settings');

            if (! File::exists($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }

            $targetPath = $targetDir.'/'.$filename;

            try {
                $manager = new ImageManager(new Driver);
                $image = $manager->read($file->getRealPath());
                $image->toPng()->save($targetPath);
                $validated['marksheet_compared_by'] = 'uploads/settings/'.$filename;
            } catch (\Throwable $e) {
                $file->move($targetDir, $filename);
                $validated['marksheet_compared_by'] = 'uploads/settings/'.$filename;
            }
        }

        if ($request->hasFile('marksheet_controller_signature')) {
            if ($setting->marksheet_controller_signature && File::exists(public_path($setting->marksheet_controller_signature))) {
                File::delete(public_path($setting->marksheet_controller_signature));
            }

            $file = $request->file('marksheet_controller_signature');
            $filename = 'marksheet_controller_signature_'.time().'.png';
            $targetDir = public_path('uploads/settings');

            if (! File::exists($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }

            $targetPath = $targetDir.'/'.$filename;

            try {
                $manager = new ImageManager(new Driver);
                $image = $manager->read($file->getRealPath());
                $image->toPng()->save($targetPath);
                $validated['marksheet_controller_signature'] = 'uploads/settings/'.$filename;
            } catch (\Throwable $e) {
                $file->move($targetDir, $filename);
                $validated['marksheet_controller_signature'] = 'uploads/settings/'.$filename;
            }
        }

        if ($request->hasFile('favicon')) {
            if ($setting->favicon && File::exists(public_path($setting->favicon))) {
                File::delete(public_path($setting->favicon));
            }

            $file = $request->file('favicon');
            $filename = 'favicon_'.time().'.'.$file->getClientOriginalExtension();
            $targetDir = public_path('uploads/settings');

            if (! File::exists($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }

            $file->move($targetDir, $filename);
            $validated['favicon'] = 'uploads/settings/'.$filename;
        }

        $setting->update($validated);

        return redirect()->route('admin.settings.index')
            ->with('success', 'University settings updated successfully.');
    }
}
