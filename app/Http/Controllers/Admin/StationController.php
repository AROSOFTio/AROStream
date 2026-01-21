<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ProvisionStationJob;
use App\Models\Domain;
use App\Models\Node;
use App\Models\Setting;
use App\Models\Station;
use App\Models\Subscription;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class StationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Station::with(['tenant', 'node', 'domains', 'subscription']);

        if (!$user->isAdmin()) {
            $query->where('tenant_id', $user->tenant_id);
        }

        $stations = $query->paginate(20);
        return view('admin.stations.index', compact('stations'));
    }

    public function create()
    {
        abort_if(!auth()->user()->isAdmin(), 403);

        return view('admin.stations.create', [
            'tenants' => Tenant::all(),
            'nodes' => Node::where('status', 'active')->get(),
            'plans' => array_keys(config('streaming.plans')),
        ]);
    }

    public function store(Request $request)
    {
        abort_if(!$request->user()->isAdmin(), 403);

        $data = $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'node_id' => 'required|exists:nodes,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|alpha_dash|unique:stations,slug',
            'plan' => 'required|in:basic,standard,pro',
        ]);

        $station = Station::create([
            'tenant_id' => $data['tenant_id'],
            'node_id' => $data['node_id'],
            'name' => $data['name'],
            'slug' => $data['slug'],
            'station_key' => Str::random(24),
            'plan' => $data['plan'],
            'status' => Station::STATUS_PROVISIONING,
            'source_password' => Crypt::encryptString(Str::random(12)),
            'admin_password' => Crypt::encryptString(Str::random(12)),
        ]);

        Domain::create([
            'station_id' => $station->id,
            'hostname' => $station->slug . '.' . config('streaming.station_default_domain_suffix'),
            'type' => 'default',
            'verification_token' => Str::random(32),
            'verified_at' => now(),
            'ssl_status' => 'active',
        ]);

        Subscription::create([
            'station_id' => $station->id,
            'plan' => $station->plan,
            'starts_at' => now(),
            'renews_at' => now()->addYear(),
            'status' => 'active',
        ]);

        ProvisionStationJob::dispatch($station->id);

        return redirect()->route('admin.stations.show', $station)->with('status', 'Station created and provisioning started.');
    }

    public function show(Station $station)
    {
        $this->authorize('view', $station);

        $station->load(['tenant', 'node', 'domains', 'subscription', 'healthSnapshots' => fn ($q) => $q->latest()->limit(5)]);
        return view('admin.stations.show', compact('station'));
    }

    public function goLive(Station $station)
    {
        $this->authorize('view', $station);

        $station->load('domains');

        $domain = $station->domains->firstWhere('type', 'custom') ?? $station->domains->first();

        try {
            $hostSetting = Setting::value('stream_public_host');
            $portSetting = Setting::value('stream_port');
            $userSetting = Setting::value('source_username');
        } catch (\Throwable $e) {
            $hostSetting = null;
            $portSetting = null;
            $userSetting = null;
        }

        $host = $hostSetting ?: ($domain?->hostname ?? 'stream.arosoft.io');
        $port = $portSetting ?: '443';
        $sourceUser = $userSetting ?: 'source';
        $mount = $station->mount_normal ?: '/live';
        $scheme = $port === '443' ? 'https' : 'http';
        $hostWithPort = in_array($port, ['80', '443'], true) ? $host : "{$host}:{$port}";
        $listenUrl = "{$scheme}://{$hostWithPort}{$mount}";

        return view('admin.stations.go-live', [
            'station' => $station,
            'streamHost' => $host,
            'streamPort' => $port,
            'sourceUser' => $sourceUser,
            'mount' => $mount,
            'listenUrl' => $listenUrl,
            'sourcePassword' => Crypt::decryptString($station->source_password),
        ]);
    }

    public function edit(Station $station)
    {
        abort_if(!auth()->user()->isAdmin(), 403);
        $this->authorize('update', $station);

        return view('admin.stations.create', [
            'station' => $station,
            'tenants' => Tenant::all(),
            'nodes' => Node::where('status', 'active')->get(),
            'plans' => array_keys(config('streaming.plans')),
        ]);
    }

    public function update(Request $request, Station $station)
    {
        abort_if(!$request->user()->isAdmin(), 403);
        $this->authorize('update', $station);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'plan' => 'required|in:basic,standard,pro',
            'node_id' => 'required|exists:nodes,id',
        ]);

        $station->update($data);

        return redirect()->route('admin.stations.show', $station)->with('status', 'Station updated.');
    }

    public function suspend(Station $station)
    {
        abort_if(!auth()->user()->isAdmin(), 403);
        $this->authorize('update', $station);

        $station->update(['status' => Station::STATUS_SUSPENDED]);

        return back()->with('status', 'Station suspended');
    }

    public function resume(Station $station)
    {
        abort_if(!auth()->user()->isAdmin(), 403);
        $this->authorize('update', $station);

        $station->update(['status' => Station::STATUS_ACTIVE]);

        return back()->with('status', 'Station resumed');
    }
}
