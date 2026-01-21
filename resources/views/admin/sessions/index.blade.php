@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-semibold">Live Sessions</h1>
</div>

<table class="min-w-full bg-white rounded shadow">
    <thead>
    <tr class="border-b">
        <th class="px-4 py-2 text-left">Station</th>
        <th class="px-4 py-2 text-left">Streamer</th>
        <th class="px-4 py-2 text-center">Status</th>
        <th class="px-4 py-2 text-center">Listeners</th>
        <th class="px-4 py-2 text-right">Started</th>
        <th class="px-4 py-2"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($sessions as $session)
        <tr class="border-b">
            <td class="px-4 py-2">{{ $session->station?->name }}</td>
            <td class="px-4 py-2">{{ $session->streamer?->name ?? 'Auto DJ' }}</td>
            <td class="px-4 py-2 text-center">{{ $session->status }}</td>
            <td class="px-4 py-2 text-center">{{ $session->listeners_current }}</td>
            <td class="px-4 py-2 text-right">{{ optional($session->started_at)->diffForHumans() }}</td>
            <td class="px-4 py-2 text-right">
                <a href="{{ route('admin.sessions.show', $session) }}" class="text-indigo-600">View</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="mt-4">{{ $sessions->links() }}</div>
@endsection
