@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-4">{{ isset($station) ? 'Edit Station' : 'Create Station' }}</h1>
<form method="POST" action="{{ isset($station) ? route('admin.stations.update', $station) : route('admin.stations.store') }}" class="bg-white p-4 rounded shadow space-y-3">
    @csrf
    @if(isset($station))
        @method('PUT')
    @endif
    <div>
        <label class="block text-sm font-medium">Name</label>
        <input class="w-full border rounded px-3 py-2" name="name" value="{{ old('name', $station->name ?? '') }}" placeholder="{{ $appSettings['station_name_format'] ?? '{tenant} FM' }}" required>
    </div>
    <div>
        <label class="block text-sm font-medium">Slug</label>
        <input class="w-full border rounded px-3 py-2" name="slug" value="{{ old('slug', $station->slug ?? '') }}" {{ isset($station) ? 'readonly' : '' }} required>
    </div>
    <div>
        <label class="block text-sm font-medium">Tenant</label>
        <select name="tenant_id" class="w-full border rounded px-3 py-2" required>
            @foreach($tenants as $tenant)
                <option value="{{ $tenant->id }}" @selected(old('tenant_id', $station->tenant_id ?? '') == $tenant->id)>{{ $tenant->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium">Node</label>
        <select name="node_id" class="w-full border rounded px-3 py-2" required>
            @foreach($nodes as $node)
                <option value="{{ $node->id }}" @selected(old('node_id', $station->node_id ?? '') == $node->id)>{{ $node->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium">Plan</label>
        <select name="plan" class="w-full border rounded px-3 py-2" required>
            @foreach($plans as $plan)
                <option value="{{ $plan }}" @selected(old('plan', $station->plan ?? ($appSettings['default_plan'] ?? 'standard')) == $plan)>{{ $plan }}</option>
            @endforeach
        </select>
    </div>
    <button class="bg-indigo-600 text-white px-4 py-2 rounded" type="submit">Save</button>
</form>
@endsection
