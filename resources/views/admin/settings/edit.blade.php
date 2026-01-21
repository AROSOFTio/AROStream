@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold">Settings</h1>
        <p class="text-gray-500">Configure branding, streaming defaults, and access.</p>
    </div>
</div>

@if (session('status'))
    <div class="mb-4 rounded bg-green-50 text-green-700 px-4 py-2">
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('admin.settings.update') }}" class="bg-white rounded shadow p-6 space-y-4">
    @csrf

    @foreach($schema as $field)
        @php
            $value = $settings[$field['key']]->value ?? '';
        @endphp
        <div>
            <label class="block text-sm font-medium text-gray-700">{{ $field['label'] }}</label>
            @if($field['type'] === 'select')
                <select name="{{ $field['key'] }}" class="mt-1 block w-full rounded border-gray-300">
                    @foreach($field['options'] as $option)
                        <option value="{{ $option }}" @selected($value === $option)>{{ ucfirst($option) }}</option>
                    @endforeach
                </select>
            @elseif($field['type'] === 'boolean')
                <div class="mt-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="{{ $field['key'] }}" value="1" class="rounded border-gray-300" @checked($value === '1')>
                        <span class="ms-2 text-sm text-gray-600">Enabled</span>
                    </label>
                </div>
            @else
                <input
                    type="{{ $field['type'] }}"
                    name="{{ $field['key'] }}"
                    value="{{ old($field['key'], $value) }}"
                    class="mt-1 block w-full rounded border-gray-300"
                >
            @endif
        </div>
    @endforeach

    <div class="pt-2">
        <button class="bg-indigo-600 text-white px-4 py-2 rounded">Save Settings</button>
    </div>
</form>
@endsection
