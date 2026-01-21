@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold">Go Live: {{ $station->name }}</h1>
    <p class="text-gray-500">Audio-only streaming with Icecast. Station owners and presenters can go live from here.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded shadow p-6 space-y-3">
        <h2 class="font-semibold text-lg">Encoder Settings (BUTT)</h2>
        <div class="text-sm text-gray-600">Use these values in BUTT (Broadcast Using This Tool).</div>
        <div class="mt-3 space-y-2 text-sm">
            <div><span class="font-semibold">Server:</span> {{ $streamHost }}</div>
            <div><span class="font-semibold">Port:</span> {{ $streamPort }}</div>
            <div><span class="font-semibold">Type:</span> Icecast</div>
            <div><span class="font-semibold">Mount:</span> {{ $mount }}</div>
            <div><span class="font-semibold">Username:</span> {{ $sourceUser }}</div>
            <div><span class="font-semibold">Password:</span> {{ $sourcePassword }}</div>
        </div>
        <div class="mt-4">
            <a href="https://danielnoethen.de/butt/" target="_blank" class="text-indigo-600">Download BUTT</a>
        </div>
    </div>

    <div class="bg-white rounded shadow p-6 space-y-3">
        <h2 class="font-semibold text-lg">Go Live Steps</h2>
        <ol class="list-decimal ml-5 text-sm text-gray-700 space-y-2">
            <li>Open BUTT and click <strong>Add</strong> under Server Settings.</li>
            <li>Paste the encoder values from the left panel.</li>
            <li>Select your microphone as the input device.</li>
            <li>Click <strong>Play</strong> to start streaming.</li>
        </ol>
        <div class="mt-4">
            <div class="text-sm text-gray-500">Public listener link</div>
            <a class="text-indigo-600" href="{{ $listenUrl }}" target="_blank">{{ $listenUrl }}</a>
        </div>
    </div>
</div>
@endsection
