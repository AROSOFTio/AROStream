@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-semibold">Tenants</h1>
    @if(auth()->user()->isAdmin())
        <a href="{{ route('admin.tenants.create') }}" class="bg-indigo-600 text-white px-3 py-2 rounded">New Tenant</a>
    @endif
</div>
<table class="min-w-full bg-white rounded shadow">
    <thead>
    <tr class="border-b">
        <th class="px-4 py-2 text-left">Name</th>
        <th class="px-4 py-2">Status</th>
        <th class="px-4 py-2">Stations</th>
        <th class="px-4 py-2"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($tenants as $tenant)
        <tr class="border-b">
            <td class="px-4 py-2">
                <a class="text-indigo-600" href="{{ route('admin.tenants.show', $tenant) }}">{{ $tenant->name }}</a>
            </td>
            <td class="px-4 py-2 text-center">{{ $tenant->status }}</td>
            <td class="px-4 py-2 text-center">{{ $tenant->stations()->count() }}</td>
            <td class="px-4 py-2 text-right">
                @if(auth()->user()->isAdmin())
                    <a class="text-indigo-600" href="{{ route('admin.tenants.edit', $tenant) }}">Edit</a>
                    <form action="{{ route('admin.tenants.destroy', $tenant) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 ms-2" onclick="return confirm('Delete this tenant?')">Delete</button>
                    </form>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="mt-4">{{ $tenants->links() }}</div>
@endsection
