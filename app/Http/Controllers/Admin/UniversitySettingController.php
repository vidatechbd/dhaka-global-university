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
            'signature' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
            'meta_author' => ['nullable', 'string', 'max:255'],
            'favicon' => ['nullable', 'file', 'mimes:ico,png,jpg,jpeg,gif,webp', 'max:1024'],
        ]);

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

        if ($request->hasFile('signature')) {
            if ($setting->signature && File::exists(public_path($setting->signature))) {
                File::delete(public_path($setting->signature));
            }

            $file = $request->file('signature');
            $filename = 'signature_'.time().'.png';
            $targetDir = public_path('uploads/settings');

            if (! File::exists($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }

            $targetPath = $targetDir.'/'.$filename;

            try {
                $manager = new ImageManager(new Driver);
                $image = $manager->read($file->getRealPath());
                $image->toPng()->save($targetPath);
                $validated['signature'] = 'uploads/settings/'.$filename;
            } catch (\Throwable $e) {
                $file->move($targetDir, $filename);
                $validated['signature'] = 'uploads/settings/'.$filename;
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
