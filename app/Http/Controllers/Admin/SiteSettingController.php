<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSiteSettingRequest;
use App\Models\SiteSetting;
use App\Support\StoresImageUploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SiteSettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings.edit', [
            'settings' => SiteSetting::current(),
        ]);
    }

    public function update(UpdateSiteSettingRequest $request): RedirectResponse
    {
        $settings = SiteSetting::current();
        $validated = $request->validated();

        $settings->fill([
            'hero_heading' => $validated['hero_heading'],
            'short_bio' => $validated['short_bio'],
            'intro_text' => $validated['intro_text'],
            'profile_image_url' => $validated['profile_image_url'] ?: null,
            'instagram_profile_url' => $validated['instagram_profile_url'] ?: null,
            'linkedin_url' => $validated['linkedin_url'] ?: null,
            'github_url' => $validated['github_url'] ?: null,
            'x_url' => $validated['x_url'] ?: null,
            'seo_title' => $validated['seo_title'],
            'seo_description' => $validated['seo_description'],
        ]);

        $settings->profile_image_path = StoresImageUploads::sync(
            $request,
            'profile_image_upload',
            $settings->profile_image_path,
            'profile',
            $request->boolean('remove_profile_image')
        );

        $settings->save();

        return redirect()->route('admin.settings.edit')
            ->with('status', 'Settings updated successfully.');
    }
}
