<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\TenantSetting;
use Illuminate\Http\Request;

class TenantSettingsController extends Controller
{
    public function edit(Request $request)
    {
        $setting = TenantSetting::firstOrCreate(
            ['tenant_id' => $request->user()->tenant_id]
        );

        return view('tenant.settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'station_name_default' => 'nullable|string|max:255',
            'frequency_default' => 'nullable|string|max:32',
            'primary_color' => 'nullable|string|max:20',
            'secondary_color' => 'nullable|string|max:20',
            'logo_url' => 'nullable|string|max:500',
            'slogan' => 'nullable|string|max:255',
        ]);

        TenantSetting::updateOrCreate(
            ['tenant_id' => $request->user()->tenant_id],
            $data
        );

        return back()->with('status', 'Tenant settings updated.');
    }
}
