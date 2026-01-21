@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold">Edit Node</h1>
</div>

<form method="POST" action="{{ route('admin.nodes.update', $node) }}" class="bg-white rounded shadow p-6 space-y-4">
    @csrf
    @method('PUT')
    <div>
        <label class="block text-sm font-medium">Name</label>
        <input class="w-full border rounded px-3 py-2" name="name" value="{{ old('name', $node->name) }}" required>
    </div>
    <div>
        <label class="block text-sm font-medium">Base URL</label>
        <input class="w-full border rounded px-3 py-2" name="base_url" value="{{ old('base_url', $node->base_url) }}" required>
    </div>
    <div>
        <label class="block text-sm font-medium">Shared Secret</label>
        <input class="w-full border rounded px-3 py-2" name="shared_secret" value="{{ old('shared_secret', $node->shared_secret) }}" required>
    </div>
    <div class="flex space-x-2">
        <input class="w-1/2 border rounded px-3 py-2" name="capacity_stations" value="{{ old('capacity_stations', $node->capacity_stations) }}" placeholder="Stations capacity">
        <input class="w-1/2 border rounded px-3 py-2" name="capacity_listeners" value="{{ old('capacity_listeners', $node->capacity_listeners) }}" placeholder="Listeners capacity">
    </div>
    <div>
        <label class="block text-sm font-medium">Status</label>
        <select class="w-full border rounded px-3 py-2" name="status">
            @foreach(['active' => 'Active', 'maintenance' => 'Maintenance', 'offline' => 'Offline'] as $value => $label)
                <option value="{{ $value }}" @selected($node->status === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <button class="bg-indigo-600 text-white px-4 py-2 rounded" type="submit">Save Changes</button>
</form>
@endsection
