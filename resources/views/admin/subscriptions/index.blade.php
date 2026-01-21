@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Subscriptions</h1>
<table class="min-w-full bg-white rounded shadow">
    <thead>
    <tr class="border-b">
        <th class="px-3 py-2 text-left">Station</th>
        <th class="px-3 py-2">Plan</th>
        <th class="px-3 py-2">Renews At</th>
        <th class="px-3 py-2">Status</th>
        <th class="px-3 py-2"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($subscriptions as $subscription)
        <tr class="border-b">
            <td class="px-3 py-2">{{ $subscription->station->name }}</td>
            <td class="px-3 py-2 text-center">{{ $subscription->plan }}</td>
            <td class="px-3 py-2 text-center">{{ optional($subscription->renews_at)->toDateString() }}</td>
            <td class="px-3 py-2 text-center">{{ $subscription->status }}</td>
            <td class="px-3 py-2 text-right">
                <form method="POST" action="{{ route('admin.subscriptions.extend', $subscription) }}">
                    @csrf
                    <button class="text-indigo-600">Extend +1y</button>
                </form>
                <a class="text-indigo-600 ms-2" href="{{ route('admin.subscriptions.edit', $subscription) }}">Edit</a>
                <form method="POST" action="{{ route('admin.subscriptions.destroy', $subscription) }}" class="inline">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600 ms-2" onclick="return confirm('Delete this subscription?')">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="mt-4">{{ $subscriptions->links() }}</div>
@endsection
