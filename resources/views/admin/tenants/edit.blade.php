@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold">Edit Tenant</h1>
</div>

<form method="POST" action="{{ route('admin.tenants.update', $tenant) }}" class="bg-white rounded shadow p-6 space-y-4">
    @csrf
    @method('PUT')
    <div>
        <label class="block text-sm font-medium text-gray-700">Name</label>
        <input name="name" value="{{ old('name', $tenant->name) }}" class="mt-1 block w-full rounded border-gray-300" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Contact Name</label>
        <input name="contact_name" value="{{ old('contact_name', $tenant->contact_name) }}" class="mt-1 block w-full rounded border-gray-300">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Contact Email</label>
        <input type="email" name="contact_email" value="{{ old('contact_email', $tenant->contact_email) }}" class="mt-1 block w-full rounded border-gray-300">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Status</label>
        <select name="status" class="mt-1 block w-full rounded border-gray-300">
            @foreach(['active' => 'Active', 'trial' => 'Trial', 'suspended' => 'Suspended'] as $value => $label)
                <option value="{{ $value }}" @selected($tenant->status === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <button class="bg-indigo-600 text-white px-4 py-2 rounded">Save Changes</button>
</form>
@endsection
