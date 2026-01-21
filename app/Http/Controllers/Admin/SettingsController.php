<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function edit()
    {
        abort_if(!auth()->user()->isAdmin(), 403);

        $settings = Setting::all()->keyBy('key');

        $schema = [
            ['key' => 'brand_name', 'label' => 'Brand Name', 'type' => 'text'],
            ['key' => 'brand_tagline', 'label' => 'Tagline', 'type' => 'text'],
            ['key' => 'logo_text', 'label' => 'Logo Text', 'type' => 'text'],
            ['key' => 'primary_color', 'label' => 'Primary Color', 'type' => 'color'],
            ['key' => 'station_name_format', 'label' => 'Station Name Format', 'type' => 'text'],
            ['key' => 'default_plan', 'label' => 'Default Plan', 'type' => 'select', 'options' => ['basic', 'standard', 'pro']],
            ['key' => 'support_email', 'label' => 'Support Email', 'type' => 'email'],
            ['key' => 'allow_registration', 'label' => 'Allow Registration', 'type' => 'boolean'],
            ['key' => 'stream_public_host', 'label' => 'Stream Public Host', 'type' => 'text'],
            ['key' => 'stream_port', 'label' => 'Stream Port', 'type' => 'text'],
            ['key' => 'source_username', 'label' => 'Source Username', 'type' => 'text'],
        ];

        return view('admin.settings.edit', compact('settings', 'schema'));
    }

    public function update(Request $request)
    {
        abort_if(!auth()->user()->isAdmin(), 403);

        $rules = [
            'brand_name' => 'required|string|max:255',
            'brand_tagline' => 'nullable|string|max:255',
            'logo_text' => 'nullable|string|max:255',
            'primary_color' => 'nullable|string|max:20',
            'station_name_format' => 'nullable|string|max:255',
            'default_plan' => 'required|in:basic,standard,pro',
            'support_email' => 'nullable|email|max:255',
            'allow_registration' => 'nullable|boolean',
            'stream_public_host' => 'nullable|string|max:255',
            'stream_port' => 'nullable|string|max:20',
            'source_username' => 'nullable|string|max:50',
        ];

        $data = $request->validate($rules);
        $data['allow_registration'] = $request->boolean('allow_registration') ? '1' : '0';

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => (string) $value,
                    'updated_by' => $request->user()->id,
                ]
            );
        }

        return back()->with('status', 'Settings updated.');
    }
}
