@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold">Edit User</h1>
</div>

<form method="POST" action="{{ route('admin.users.update', $user) }}" class="bg-white rounded shadow p-6 space-y-4">
    @csrf
    @method('PUT')
    <div>
        <label class="block text-sm font-medium text-gray-700">Name</label>
        <input name="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full rounded border-gray-300" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full rounded border-gray-300" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Password (leave blank to keep)</label>
        <input type="password" name="password" class="mt-1 block w-full rounded border-gray-300">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Role</label>
        <select name="role" class="mt-1 block w-full rounded border-gray-300">
            <option value="customer" @selected($user->role === 'customer')>Tenant User</option>
            <option value="admin" @selected($user->role === 'admin')>Admin</option>
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Tenant</label>
        <select name="tenant_id" class="mt-1 block w-full rounded border-gray-300">
            <option value="">None</option>
            @foreach($tenants as $tenant)
                <option value="{{ $tenant->id }}" @selected($user->tenant_id === $tenant->id)>{{ $tenant->name }}</option>
            @endforeach
        </select>
    </div>
    <button class="bg-indigo-600 text-white px-4 py-2 rounded">Save Changes</button>
</form>
@endsection
