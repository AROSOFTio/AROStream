<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use App\Models\Station;
use App\Services\Domains\DomainVerifier;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DomainController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Domain::with('station');

        if (!$user->isAdmin()) {
            $query->whereHas('station', fn ($q) => $q->where('tenant_id', $user->tenant_id));
        }

        $domains = $query->paginate(30);
        return view('admin.domains.index', compact('domains'));
    }

    public function create()
    {
        abort_if(!auth()->user()->isAdmin(), 403);

        return view('admin.domains.create', [
            'stations' => Station::with('tenant')->get(),
        ]);
    }

    public function store(Request $request)
    {
        abort_if(!$request->user()->isAdmin(), 403);

        $data = $request->validate([
            'station_id' => 'required|exists:stations,id',
            'hostname' => 'required|string|unique:domains,hostname',
        ]);

        $domain = Domain::create([
            'station_id' => $data['station_id'],
            'hostname' => $data['hostname'],
            'type' => 'custom',
            'verification_token' => Str::random(32),
            'ssl_status' => 'pending',
        ]);

        return redirect()->route('admin.domains.index')->with('status', "Domain {$domain->hostname} added. Add TXT record to verify.");
    }

    public function verify(Domain $domain, DomainVerifier $verifier)
    {
        $this->authorize('update', $domain);

        $verified = $verifier->verify($domain);

        return back()->with('status', $verified ? 'Domain verified.' : 'Verification token not found. Try again after DNS propagates.');
    }

    public function edit(Domain $domain)
    {
        abort_if(!auth()->user()->isAdmin(), 403);

        return view('admin.domains.edit', compact('domain'));
    }

    public function update(Request $request, Domain $domain)
    {
        abort_if(!$request->user()->isAdmin(), 403);

        $data = $request->validate([
            'hostname' => 'required|string|unique:domains,hostname,' . $domain->id,
            'ssl_status' => 'required|in:pending,active,failed',
        ]);

        $domain->update($data);

        return redirect()->route('admin.domains.index')->with('status', 'Domain updated.');
    }

    public function destroy(Domain $domain)
    {
        abort_if(!auth()->user()->isAdmin(), 403);

        $domain->delete();

        return back()->with('status', 'Domain deleted.');
    }
}
