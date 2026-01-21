@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold">Tenant Overview</h1>
    <p class="text-gray-500">Your live streaming activity and stations.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
    <div class="bg-white rounded shadow p-4">
        <div class="text-sm text-gray-500">Live listeners</div>
        <div class="text-3xl font-semibold">{{ $listenersLive }}</div>
    </div>
    <div class="bg-white rounded shadow p-4">
        <div class="text-sm text-gray-500">Stations</div>
        <div class="text-3xl font-semibold">{{ $stations }}</div>
    </div>
    <div class="bg-white rounded shadow p-4">
        <div class="text-sm text-gray-500">Streamers</div>
        <div class="text-3xl font-semibold">{{ $streamers }}</div>
    </div>
</div>

<div class="bg-white rounded shadow">
    <div class="px-4 py-3 border-b">
        <h2 class="font-semibold">Live sessions</h2>
    </div>
    <div class="p-4">
        @if($liveSessions->isEmpty())
            <p class="text-gray-500">No live sessions right now.</p>
        @else
            <table class="min-w-full text-sm">
                <thead>
                <tr class="border-b text-left">
                    <th class="py-2">Station</th>
                    <th class="py-2">Streamer</th>
                    <th class="py-2 text-center">Listeners</th>
                    <th class="py-2 text-right">Started</th>
                </tr>
                </thead>
                <tbody>
                @foreach($liveSessions as $session)
                    <tr class="border-b">
                        <td class="py-2">{{ $session->station?->name }}</td>
                        <td class="py-2">{{ $session->streamer?->name ?? 'Auto DJ' }}</td>
                        <td class="py-2 text-center">{{ $session->listeners_current }}</td>
                        <td class="py-2 text-right">{{ optional($session->started_at)->diffForHumans() }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
