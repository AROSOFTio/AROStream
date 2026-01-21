@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Add Domain</h1>
<form method="POST" action="{{ route('admin.domains.store') }}" class="bg-white p-4 rounded shadow space-y-3">
    @csrf
    <div>
        <label class="block text-sm font-medium">Hostname</label>
        <input class="w-full border rounded px-3 py-2" name="hostname" placeholder="stream.example.com" required>
    </div>
    <div>
        <label class="block text-sm font-medium">Station</label>
        <select name="station_id" class="w-full border rounded px-3 py-2" required>
            @foreach($stations as $station)
                <option value="{{ $station->id }}">{{ $station->tenant->name }} - {{ $station->name }}</option>
            @endforeach
        </select>
    </div>
    <button class="bg-indigo-600 text-white px-4 py-2 rounded" type="submit">Save</button>
</form>
@endsection
