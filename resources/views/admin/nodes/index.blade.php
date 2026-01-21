@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-semibold">Nodes</h1>
</div>
<table class="min-w-full bg-white rounded shadow mb-4">
    <thead>
    <tr class="border-b">
        <th class="px-3 py-2 text-left">Name</th>
        <th class="px-3 py-2">Base URL</th>
        <th class="px-3 py-2">Status</th>
        <th class="px-3 py-2"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($nodes as $node)
        <tr class="border-b">
            <td class="px-3 py-2">{{ $node->name }}</td>
            <td class="px-3 py-2">{{ $node->base_url }}</td>
            <td class="px-3 py-2 text-center">{{ $node->status }}</td>
            <td class="px-3 py-2 text-right">
                <a href="{{ route('admin.nodes.edit', $node) }}" class="text-indigo-600">Edit</a>
                <form action="{{ route('admin.nodes.destroy', $node) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600 ms-2" onclick="return confirm('Delete this node?')">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<form method="POST" action="{{ route('admin.nodes.store') }}" class="bg-white p-4 rounded shadow space-y-3">
    @csrf
    <h2 class="font-semibold">Add Node</h2>
    <div>
        <label class="block text-sm font-medium">Name</label>
        <input class="w-full border rounded px-3 py-2" name="name" required>
    </div>
    <div>
        <label class="block text-sm font-medium">Base URL</label>
        <input class="w-full border rounded px-3 py-2" name="base_url" placeholder="https://node1.example.com" required>
    </div>
    <div>
        <label class="block text-sm font-medium">Shared Secret</label>
        <input class="w-full border rounded px-3 py-2" name="shared_secret" required>
    </div>
    <div class="flex space-x-2">
        <input class="w-1/2 border rounded px-3 py-2" name="capacity_stations" placeholder="Stations capacity">
        <input class="w-1/2 border rounded px-3 py-2" name="capacity_listeners" placeholder="Listeners capacity">
    </div>
    <div>
        <label class="block text-sm font-medium">Status</label>
        <select class="w-full border rounded px-3 py-2" name="status">
            <option value="active">Active</option>
            <option value="maintenance">Maintenance</option>
            <option value="offline">Offline</option>
        </select>
    </div>
    <button class="bg-indigo-600 text-white px-4 py-2 rounded" type="submit">Save</button>
</form>
@endsection
