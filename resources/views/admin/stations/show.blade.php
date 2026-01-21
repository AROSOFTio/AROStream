@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-2">
    <h1 class="text-2xl font-semibold">{{ $station->name }}</h1>
    <a class="bg-indigo-600 text-white px-3 py-2 rounded" href="{{ auth()->user()->isAdmin() ? route('admin.stations.go-live', $station) : route('tenant.stations.go-live', $station) }}">Go Live</a>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="bg-white p-4 rounded shadow">
        <h2 class="font-semibold mb-2">Details</h2>
        <p>Tenant: {{ $station->tenant->name }}</p>
        <p>Plan: {{ $station->plan }}</p>
        <p>Status: {{ $station->status }}</p>
        <p>Node: {{ $station->node->name }}</p>
        <p>Slug: {{ $station->slug }}</p>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <h2 class="font-semibold mb-2">Stream URLs</h2>
        <ul class="list-disc ml-5">
            @foreach($station->domains as $domain)
                <li>{{ $domain->hostname }}</li>
            @endforeach
        </ul>
        <p class="mt-2 text-sm text-gray-600">Default: {{ $station->slug }}.{{ config('streaming.station_default_domain_suffix') }}</p>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <h2 class="font-semibold mb-2">Domain Mapping</h2>
        <p class="text-sm text-gray-700 mb-2">Point your custom domain to the platform edge proxy. For DNS verification add a TXT record:</p>
        @foreach($station->domains as $domain)
            @if($domain->type === 'custom')
                <div class="text-sm mb-1">
                    <div>Host: {{ config('streaming.dns_verification_prefix') }}.{{ $domain->hostname }}</div>
                    <div>Value: {{ $domain->verification_token }}</div>
                    <div>Status: {{ $domain->verified_at ? 'Verified' : 'Pending' }}</div>
                </div>
            @endif
        @endforeach
        <p class="text-xs text-gray-600 mt-2">SSL is handled by the edge proxy; keep Cloudflare set to DNS-only for streaming hostnames.</p>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <h2 class="font-semibold mb-2">Encoder Settings</h2>
        <p>Host: stream.arosoft.io (or custom domain)</p>
        <p>Port: 443</p>
        <p>Mounts: {{ $station->mount_normal }} ({{ $station->bitrate_normal }}kbps), {{ $station->mount_low }} ({{ $station->bitrate_low }}kbps)</p>
        <p>Source password: <code>{{ Crypt::decryptString($station->source_password) }}</code></p>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <h2 class="font-semibold mb-2">Health</h2>
        @php($latest = $station->healthSnapshots->first())
        <p>Online: {{ $latest?->online ? 'Yes' : 'No' }}</p>
        <p>Listeners: {{ $latest?->listeners ?? '-' }}</p>
        <p>Checked: {{ optional($latest?->checked_at)->diffForHumans() }}</p>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <h2 class="font-semibold mb-2">Billing</h2>
        <p>Plan: {{ $station->subscription?->plan ?? '-' }}</p>
        <p>Renews: {{ optional($station->subscription?->renews_at)->toDateString() ?? '-' }}</p>
        <p>Status: {{ $station->subscription?->status ?? '-' }}</p>
    </div>
</div>
<div class="mt-4 flex space-x-2">
    <form method="POST" action="{{ route('admin.stations.suspend', $station) }}">
        @csrf
        <button class="bg-yellow-500 text-white px-3 py-2 rounded" type="submit">Suspend</button>
    </form>
    <form method="POST" action="{{ route('admin.stations.resume', $station) }}">
        @csrf
        <button class="bg-green-600 text-white px-3 py-2 rounded" type="submit">Resume</button>
    </form>
</div>
@endsection
