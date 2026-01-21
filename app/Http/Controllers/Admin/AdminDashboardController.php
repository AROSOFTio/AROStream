<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use App\Models\Node;
use App\Models\Station;
use App\Models\StreamSession;
use App\Models\Streamer;
use App\Models\Tenant;

class AdminDashboardController extends Controller
{
    public function index()
    {
        abort_if(!auth()->user()->isAdmin(), 403);

        $stations = Station::count();
        $tenants = Tenant::count();
        $nodes = Node::count();
        $domains = Domain::count();
        $streamers = Streamer::count();

        $liveSessions = StreamSession::with(['station', 'streamer'])
            ->where('status', 'live')
            ->orderByDesc('listeners_current')
            ->limit(5)
            ->get();

        $listenersLive = StreamSession::where('status', 'live')->sum('listeners_current');
        $alerts = Station::whereIn('status', [Station::STATUS_SUSPENDED, Station::STATUS_ERRORED])->count();

        return view('admin.dashboard', compact(
            'stations',
            'tenants',
            'nodes',
            'domains',
            'streamers',
            'listenersLive',
            'alerts',
            'liveSessions'
        ));
    }
}
