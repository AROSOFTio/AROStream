@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold">Session Details</h1>
    <p class="text-gray-500">Stream activity, listeners, and metadata.</p>
</div>

<div class="bg-white rounded shadow p-6 space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <div class="text-sm text-gray-500">Station</div>
            <div class="text-lg font-semibold">{{ $session->station?->name }}</div>
        </div>
        <div>
            <div class="text-sm text-gray-500">Streamer</div>
            <div class="text-lg font-semibold">{{ $session->streamer?->name ?? 'Auto DJ' }}</div>
        </div>
        <div>
            <div class="text-sm text-gray-500">Status</div>
            <div class="text-lg font-semibold">{{ $session->status }}</div>
        </div>
        <div>
            <div class="text-sm text-gray-500">Bitrate</div>
            <div class="text-lg font-semibold">{{ $session->bitrate_kbps }} kbps</div>
        </div>
        <div>
            <div class="text-sm text-gray-500">Started</div>
            <div class="text-lg font-semibold">{{ optional($session->started_at)->toDayDateTimeString() }}</div>
        </div>
        <div>
            <div class="text-sm text-gray-500">Ended</div>
            <div class="text-lg font-semibold">{{ optional($session->ended_at)->toDayDateTimeString() ?? 'Live' }}</div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-gray-50 rounded p-4">
            <div class="text-sm text-gray-500">Current listeners</div>
            <div class="text-xl font-semibold">{{ $session->listeners_current }}</div>
        </div>
        <div class="bg-gray-50 rounded p-4">
            <div class="text-sm text-gray-500">Peak listeners</div>
            <div class="text-xl font-semibold">{{ $session->listeners_peak }}</div>
        </div>
        <div class="bg-gray-50 rounded p-4">
            <div class="text-sm text-gray-500">Average listeners</div>
            <div class="text-xl font-semibold">{{ $session->listeners_avg }}</div>
        </div>
    </div>

    <div>
        <div class="text-sm text-gray-500 mb-2">Metadata</div>
        <pre class="bg-gray-900 text-gray-100 rounded p-4 text-sm">{{ json_encode($session->metadata, JSON_PRETTY_PRINT) }}</pre>
    </div>
</div>
@endsection
