@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold">Edit Subscription</h1>
</div>

<form method="POST" action="{{ route('admin.subscriptions.update', $subscription) }}" class="bg-white rounded shadow p-6 space-y-4">
    @csrf
    @method('PUT')
    <div>
        <label class="block text-sm font-medium text-gray-700">Plan</label>
        <select name="plan" class="mt-1 block w-full rounded border-gray-300">
            @foreach(['basic' => 'Basic', 'standard' => 'Standard', 'pro' => 'Pro'] as $value => $label)
                <option value="{{ $value }}" @selected($subscription->plan === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Status</label>
        <select name="status" class="mt-1 block w-full rounded border-gray-300">
            @foreach(['active' => 'Active', 'past_due' => 'Past Due', 'cancelled' => 'Cancelled'] as $value => $label)
                <option value="{{ $value }}" @selected($subscription->status === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Renews At</label>
        <input type="date" name="renews_at" value="{{ optional($subscription->renews_at)->toDateString() }}" class="mt-1 block w-full rounded border-gray-300" required>
    </div>
    <button class="bg-indigo-600 text-white px-4 py-2 rounded">Save Changes</button>
</form>
@endsection
