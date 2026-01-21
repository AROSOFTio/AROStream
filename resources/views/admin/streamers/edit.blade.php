@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold">Edit Streamer</h1>
</div>

<form method="POST" action="{{ route('admin.streamers.update', $streamer) }}" class="bg-white rounded shadow p-6 space-y-4">
    @csrf
    @method('PUT')
    <div>
        <label class="block text-sm font-medium text-gray-700">Name</label>
        <input name="name" value="{{ old('name', $streamer->name) }}" class="mt-1 block w-full rounded border-gray-300" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Handle</label>
        <input name="handle" value="{{ old('handle', $streamer->handle) }}" class="mt-1 block w-full rounded border-gray-300" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Status</label>
        <select name="status" class="mt-1 block w-full rounded border-gray-300">
            @foreach(['live' => 'Live', 'offline' => 'Offline', 'away' => 'Away'] as $value => $label)
                <option value="{{ $value }}" @selected($streamer->status === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Tenant</label>
        <select name="tenant_id" class="mt-1 block w-full rounded border-gray-300">
            <option value="">None</option>
            @foreach($tenants as $tenant)
                <option value="{{ $tenant->id }}" @selected($streamer->tenant_id === $tenant->id)>{{ $tenant->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Station</label>
        <select name="station_id" class="mt-1 block w-full rounded border-gray-300">
            <option value="">None</option>
            @foreach($stations as $station)
                <option value="{{ $station->id }}" @selected($streamer->station_id === $station->id)>{{ $station->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Bio</label>
        <textarea name="bio" rows="3" class="mt-1 block w-full rounded border-gray-300" placeholder="Short bio about the streamer...">{{ old('bio', $streamer->bio) }}</textarea>
    </div>

    <button class="bg-indigo-600 text-white px-4 py-2 rounded">Save Changes</button>
</form>
@endsection
