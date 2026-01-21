@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-semibold">Streamers</h1>
    @if(auth()->user()->isAdmin())
        <a href="{{ route('admin.streamers.create') }}" class="bg-indigo-600 text-white px-3 py-2 rounded">New Streamer</a>
    @endif
</div>

@if (session('status'))
    <div class="mb-4 rounded bg-green-50 text-green-700 px-4 py-2">
        {{ session('status') }}
    </div>
@endif

<table class="min-w-full bg-white rounded shadow">
    <thead>
    <tr class="border-b">
        <th class="px-4 py-2 text-left">Name</th>
        <th class="px-4 py-2 text-left">Handle</th>
        <th class="px-4 py-2">Status</th>
        <th class="px-4 py-2 text-left">Station</th>
        <th class="px-4 py-2 text-left">Tenant</th>
        <th class="px-4 py-2"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($streamers as $streamer)
        <tr class="border-b">
            <td class="px-4 py-2">{{ $streamer->name }}</td>
            <td class="px-4 py-2 text-gray-500">{{ '@' . $streamer->handle }}</td>
            <td class="px-4 py-2 text-center">{{ $streamer->status }}</td>
            <td class="px-4 py-2">{{ $streamer->station?->name ?? '-' }}</td>
            <td class="px-4 py-2">{{ $streamer->tenant?->name ?? '-' }}</td>
            <td class="px-4 py-2 text-right">
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.streamers.edit', $streamer) }}" class="text-indigo-600">Edit</a>
                    <form action="{{ route('admin.streamers.destroy', $streamer) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 ms-2" onclick="return confirm('Delete this streamer?')">Delete</button>
                    </form>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="mt-4">{{ $streamers->links() }}</div>
@endsection
