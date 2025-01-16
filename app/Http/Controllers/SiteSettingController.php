<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function AdminSiteSetting()
    {
        $setting = SiteSetting::first();

        if (!$setting) {
            // Create default settings if none exist
            $setting = SiteSetting::create([
                'logo' => 'logo.svg',
                'slogan' => 'Awesome grocery store website template',
                'support_phone' => '20022025',
                'email' => 'support@example.com',
                'address' => 'RFH Mir, Flat # 1A & 1B, House # 3, Road # 1, Habib Lane, North Khulshi, Chattogram, Bangladesh',
                'facebook_username' => '#',
                'twitter_username' => '#',
                'instagram_username' => '#',
                'youtube_username' => '#',
                'timezone' => 'UTC',
                'open_hours' => '9AM-5PM',
                'open_days' => 'Mon-Fri',
                'maintenance_mode' => false,
            ]);
        }

        return view('backend.setting.index', compact('setting'));
    }

    public function UpdateSiteSetting(Request $request)
    {
        $setting = SiteSetting::first();

        if (!$setting) {
            return redirect()->route('admin.site.setting')->with('error', 'No settings found to update.');
        }

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            // Get the original filename
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Save file directory
            $destinationPath = public_path('frontend/assets/imgs/theme');
            $file->move($destinationPath, $fileName);

            // Check if the current logo is not logo.svg
            if ($setting->logo !== 'frontend/assets/imgs/theme/logo.svg' && file_exists(public_path($setting->logo))) {
                unlink(public_path($setting->logo));
            }

            // Update the logo path
            $setting->logo = $fileName;
        }

        // Update other fields
        $setting->slogan = $request->slogan ?? $setting->slogan;
        $setting->support_phone = $request->support_phone ?? $setting->support_phone;
        $setting->email = $request->email ?? $setting->email;
        $setting->address = $request->address ?? $setting->address;
        $setting->timezone = $request->timezone ?? $setting->timezone;
        $setting->open_hours = $request->open_hours ?? $setting->open_hours;
        $setting->open_days = $request->open_days ?? $setting->open_days;
        $setting->maintenance_mode = $request->maintenance_mode ?? $setting->maintenance_mode;

        // Update Social Media Usernames
        $setting->facebook_username = $request->facebook_username ?? $setting->facebook_username;
        $setting->twitter_username = $request->twitter_username ?? $setting->twitter_username;
        $setting->instagram_username = $request->instagram_username ?? $setting->instagram_username;
        $setting->youtube_username = $request->youtube_username ?? $setting->youtube_username;

        // Save the updated settings
        $setting->save();

        // Send notification
        $notification = array(
            'alert-type' => 'success',
            'message'   => 'Site settings updated successfully.'
        );

        return redirect()->route('admin.site.setting')->with($notification);
    }

    public function ResetSiteSetting()
    {
        $defaultSettings = [
            'logo' => 'logo.svg',
            'slogan' => 'Awesome grocery store website template',
            'support_phone' => '20022025',
            'email' => 'support@example.com',
            'address' => 'RFH Mir, Flat # 1A & 1B, House # 3, Road # 1, Habib Lane, North Khulshi, Chattogram, Bangladesh',
            'facebook_username' => '#',
            'twitter_username' => '#',
            'instagram_username' => '#',
            'youtube_username' => '#',
            'timezone' => 'UTC',
            'open_hours' => '9AM-5PM',
            'open_days' => 'Mon-Fri',
            'maintenance_mode' => false,
        ];

        $setting = SiteSetting::first();

        if (!$setting) {
            // Create the default settings if none exist
            $setting = SiteSetting::create($defaultSettings);
        } else {
            // Reset to default values
            $setting->update($defaultSettings);
        }

        $notification = array(
            'alert-type' => 'info',
            'message'   => 'Site settings have been reset to default values.'
        );

        return redirect()->route('admin.site.setting')->with($notification);
    }
}
