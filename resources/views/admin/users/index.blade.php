@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-semibold">Users</h1>
    <a href="{{ route('admin.users.create') }}" class="bg-indigo-600 text-white px-3 py-2 rounded">New User</a>
</div>

<table class="min-w-full bg-white rounded shadow">
    <thead>
    <tr class="border-b">
        <th class="px-4 py-2 text-left">Name</th>
        <th class="px-4 py-2 text-left">Email</th>
        <th class="px-4 py-2">Role</th>
        <th class="px-4 py-2 text-left">Tenant</th>
        <th class="px-4 py-2"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr class="border-b">
            <td class="px-4 py-2">{{ $user->name }}</td>
            <td class="px-4 py-2">{{ $user->email }}</td>
            <td class="px-4 py-2 text-center">{{ $user->role }}</td>
            <td class="px-4 py-2">{{ $user->tenant?->name ?? '-' }}</td>
            <td class="px-4 py-2 text-right">
                <a href="{{ route('admin.users.edit', $user) }}" class="text-indigo-600">Edit</a>
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600 ms-2" onclick="return confirm('Delete this user?')">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="mt-4">{{ $users->links() }}</div>
@endsection
