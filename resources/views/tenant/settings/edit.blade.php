@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold">Tenant Settings</h1>
    <p class="text-gray-500">Customize station branding defaults and identity.</p>
</div>

@if (session('status'))
    <div class="mb-4 rounded bg-green-50 text-green-700 px-4 py-2">
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('tenant.settings.update') }}" class="bg-white rounded shadow p-6 space-y-4">
    @csrf
    <div>
        <label class="block text-sm font-medium text-gray-700">Default Station Name</label>
        <input name="station_name_default" value="{{ old('station_name_default', $setting->station_name_default) }}" class="mt-1 block w-full rounded border-gray-300" placeholder="Aurora FM">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Default Frequency</label>
        <input name="frequency_default" value="{{ old('frequency_default', $setting->frequency_default) }}" class="mt-1 block w-full rounded border-gray-300" placeholder="99.9">
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Primary Color</label>
            <input type="color" name="primary_color" value="{{ old('primary_color', $setting->primary_color) }}" class="mt-1 block w-full rounded border-gray-300">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Secondary Color</label>
            <input type="color" name="secondary_color" value="{{ old('secondary_color', $setting->secondary_color) }}" class="mt-1 block w-full rounded border-gray-300">
        </div>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Logo URL</label>
        <input name="logo_url" value="{{ old('logo_url', $setting->logo_url) }}" class="mt-1 block w-full rounded border-gray-300" placeholder="https://cdn.example.com/logo.png">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Slogan</label>
        <input name="slogan" value="{{ old('slogan', $setting->slogan) }}" class="mt-1 block w-full rounded border-gray-300" placeholder="Streaming that never sleeps">
    </div>
    <button class="bg-indigo-600 text-white px-4 py-2 rounded">Save Settings</button>
</form>
@endsection
