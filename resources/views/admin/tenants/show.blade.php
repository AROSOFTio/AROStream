@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-semibold">{{ $tenant->name }}</h1>
    @if(auth()->user()->isAdmin())
        <a class="text-indigo-600" href="{{ route('admin.tenants.edit', $tenant) }}">Edit Tenant</a>
    @endif
</div>
<div class="bg-white p-4 rounded shadow mb-4">
    <p>Contact: {{ $tenant->contact_name }} ({{ $tenant->contact_email }})</p>
    <p>Status: {{ $tenant->status }}</p>
</div>
<h2 class="text-xl font-semibold mb-2">Stations</h2>
<ul class="bg-white rounded shadow divide-y">
    @foreach($tenant->stations as $station)
        <li class="px-4 py-2 flex justify-between">
            <span>{{ $station->name }} ({{ $station->plan }})</span>
            <a class="text-indigo-600" href="{{ route('admin.stations.show', $station) }}">View</a>
        </li>
    @endforeach
</ul>
@endsection
