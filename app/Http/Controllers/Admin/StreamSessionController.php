<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StreamSession;

class StreamSessionController extends Controller
{
    public function index()
    {
        $query = StreamSession::with(['station', 'streamer'])
            ->orderByDesc('started_at');

        if (!auth()->user()->isAdmin()) {
            $query->whereHas('station', fn ($q) => $q->where('tenant_id', auth()->user()->tenant_id));
        }

        $sessions = $query->paginate(20);

        return view('admin.sessions.index', compact('sessions'));
    }

    public function show(StreamSession $session)
    {
        if (!auth()->user()->isAdmin()) {
            abort_if($session->station->tenant_id !== auth()->user()->tenant_id, 403);
        }

        $session->load(['station', 'streamer']);

        return view('admin.sessions.show', compact('session'));
    }
}
