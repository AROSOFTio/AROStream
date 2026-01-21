<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Station;
use App\Models\StreamSession;
use App\Models\Streamer;
use Illuminate\Http\Request;

class TenantDashboardController extends Controller
{
    public function index(Request $request)
    {
        $tenantId = $request->user()->tenant_id;

        $stations = Station::where('tenant_id', $tenantId)->count();
        $streamers = Streamer::where('tenant_id', $tenantId)->count();

        $liveSessions = StreamSession::with(['station', 'streamer'])
            ->whereHas('station', fn ($q) => $q->where('tenant_id', $tenantId))
            ->where('status', 'live')
            ->orderByDesc('listeners_current')
            ->limit(5)
            ->get();

        $listenersLive = StreamSession::whereHas('station', fn ($q) => $q->where('tenant_id', $tenantId))
            ->where('status', 'live')
            ->sum('listeners_current');

        return view('tenant.dashboard', compact('stations', 'streamers', 'listenersLive', 'liveSessions'));
    }
}
