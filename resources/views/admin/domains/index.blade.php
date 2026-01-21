@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-semibold">Domains</h1>
    <a href="{{ route('admin.domains.create') }}" class="bg-indigo-600 text-white px-3 py-2 rounded">Add Domain</a>
</div>
<table class="min-w-full bg-white rounded shadow">
    <thead>
    <tr class="border-b">
        <th class="px-3 py-2 text-left">Hostname</th>
        <th class="px-3 py-2">Station</th>
        <th class="px-3 py-2">Verified</th>
        <th class="px-3 py-2">SSL</th>
        <th class="px-3 py-2"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($domains as $domain)
        <tr class="border-b">
            <td class="px-3 py-2">{{ $domain->hostname }}</td>
            <td class="px-3 py-2 text-center">{{ $domain->station->name }}</td>
            <td class="px-3 py-2 text-center">{{ $domain->verified_at ? 'Yes' : 'No' }}</td>
            <td class="px-3 py-2 text-center">{{ $domain->ssl_status }}</td>
            <td class="px-3 py-2 text-right">
                <form method="POST" action="{{ route('admin.domains.verify', $domain) }}">
                    @csrf
                    <button class="text-indigo-600">Verify</button>
                </form>
                <a class="text-indigo-600 ms-2" href="{{ route('admin.domains.edit', $domain) }}">Edit</a>
                <form method="POST" action="{{ route('admin.domains.destroy', $domain) }}" class="inline">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600 ms-2" onclick="return confirm('Delete this domain?')">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="mt-4">{{ $domains->links() }}</div>
@endsection
