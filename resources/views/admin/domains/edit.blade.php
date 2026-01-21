@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold">Edit Domain</h1>
</div>

<form method="POST" action="{{ route('admin.domains.update', $domain) }}" class="bg-white rounded shadow p-6 space-y-4">
    @csrf
    @method('PUT')
    <div>
        <label class="block text-sm font-medium text-gray-700">Hostname</label>
        <input name="hostname" value="{{ old('hostname', $domain->hostname) }}" class="mt-1 block w-full rounded border-gray-300" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">SSL Status</label>
        <select name="ssl_status" class="mt-1 block w-full rounded border-gray-300">
            @foreach(['pending' => 'Pending', 'active' => 'Active', 'failed' => 'Failed'] as $value => $label)
                <option value="{{ $value }}" @selected($domain->ssl_status === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <button class="bg-indigo-600 text-white px-4 py-2 rounded">Save Changes</button>
</form>
@endsection
