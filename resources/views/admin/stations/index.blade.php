@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-semibold">Stations</h1>
    <a href="{{ route('admin.stations.create') }}" class="bg-indigo-600 text-white px-3 py-2 rounded">New Station</a>
    </div>
<table class="min-w-full bg-white rounded shadow">
    <thead>
    <tr class="border-b">
        <th class="px-3 py-2 text-left">Name</th>
        <th class="px-3 py-2 text-left">Tenant</th>
        <th class="px-3 py-2">Plan</th>
        <th class="px-3 py-2">Status</th>
        <th class="px-3 py-2">Domains</th>
        <th class="px-3 py-2">Listeners</th>
        <th class="px-3 py-2"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($stations as $station)
        <tr class="border-b">
            <td class="px-3 py-2">
                <a class="text-indigo-600" href="{{ route('admin.stations.show', $station) }}">{{ $station->name }}</a>
            </td>
            <td class="px-3 py-2">{{ $station->tenant->name }}</td>
            <td class="px-3 py-2 text-center">{{ $station->plan }}</td>
            <td class="px-3 py-2 text-center">{{ $station->status }}</td>
            <td class="px-3 py-2 text-center">{{ $station->domains()->count() }}</td>
            <td class="px-3 py-2 text-center">{{ optional($station->healthSnapshots()->latest('checked_at')->first())->listeners ?? '-' }}</td>
            <td class="px-3 py-2 text-right">
                <a class="text-indigo-600" href="{{ route('admin.stations.edit', $station) }}">Edit</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="mt-4">{{ $stations->links() }}</div>
@endsection
