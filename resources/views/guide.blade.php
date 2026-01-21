@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold">Getting Started: Go Live with Icecast</h1>
    <p class="text-gray-500">Audio-only streaming with BUTT and your station settings.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded shadow p-6 space-y-4">
        <h2 class="font-semibold text-lg">Step-by-step</h2>
        <ol class="list-decimal ml-5 text-sm text-gray-700 space-y-2">
            <li>Open your station page and click <strong>Go Live</strong>.</li>
            <li>Copy the encoder settings (Server, Port, Mount, Username, Password).</li>
            <li>Download and install BUTT: <a class="text-indigo-600" href="https://danielnoethen.de/butt/" target="_blank">danielnoethen.de/butt</a>.</li>
            <li>In BUTT, click <strong>Add</strong> under Server Settings and paste the values.</li>
            <li>Select your microphone as the input source.</li>
            <li>Click <strong>Play</strong> to start streaming.</li>
            <li>Open the public listener link shown on the Go Live page to confirm audio.</li>
        </ol>
    </div>

    <div class="bg-white rounded shadow p-6 space-y-4">
        <h2 class="font-semibold text-lg">Quick Checks</h2>
        <ul class="list-disc ml-5 text-sm text-gray-700 space-y-2">
            <li>Icecast must be running on your server (Contabo).</li>
            <li>DNS for your stream domain points to the Icecast server.</li>
            <li>Port 443 is open and forwarded to Icecast.</li>
            <li>The source password matches what you see on the Go Live page.</li>
        </ul>
        <div class="mt-4 text-sm text-gray-500">
            If you hear silence, confirm your mic input and check the Icecast admin logs.
        </div>
    </div>
</div>
@endsection
