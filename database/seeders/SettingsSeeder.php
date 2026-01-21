<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            [
                'key' => 'brand_name',
                'value' => 'AROStream',
                'group' => 'branding',
                'label' => 'Brand Name',
                'type' => 'text',
            ],
            [
                'key' => 'brand_tagline',
                'value' => 'Number one streaming software in the world',
                'group' => 'branding',
                'label' => 'Tagline',
                'type' => 'text',
            ],
            [
                'key' => 'logo_text',
                'value' => 'AROStream',
                'group' => 'branding',
                'label' => 'Logo Text',
                'type' => 'text',
            ],
            [
                'key' => 'primary_color',
                'value' => '#ff6b35',
                'group' => 'branding',
                'label' => 'Primary Color',
                'type' => 'color',
            ],
            [
                'key' => 'station_name_format',
                'value' => '{tenant} FM',
                'group' => 'streaming',
                'label' => 'Station Name Format',
                'type' => 'text',
            ],
            [
                'key' => 'default_plan',
                'value' => 'standard',
                'group' => 'streaming',
                'label' => 'Default Plan',
                'type' => 'select',
            ],
            [
                'key' => 'support_email',
                'value' => 'support@arostream.io',
                'group' => 'contact',
                'label' => 'Support Email',
                'type' => 'email',
            ],
            [
                'key' => 'allow_registration',
                'value' => '1',
                'group' => 'auth',
                'label' => 'Allow Registration',
                'type' => 'boolean',
            ],
            [
                'key' => 'stream_public_host',
                'value' => 'stream.arosoft.io',
                'group' => 'streaming',
                'label' => 'Stream Public Host',
                'type' => 'text',
            ],
            [
                'key' => 'stream_port',
                'value' => '443',
                'group' => 'streaming',
                'label' => 'Stream Port',
                'type' => 'text',
            ],
            [
                'key' => 'source_username',
                'value' => 'source',
                'group' => 'streaming',
                'label' => 'Source Username',
                'type' => 'text',
            ],
        ];

        foreach ($defaults as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
