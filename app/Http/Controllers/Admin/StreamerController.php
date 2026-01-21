<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Station;
use App\Models\Streamer;
use App\Models\Tenant;
use Illuminate\Http\Request;

class StreamerController extends Controller
{
    public function index()
    {
        $query = Streamer::with(['tenant', 'station']);

        if (!auth()->user()->isAdmin()) {
            $query->where('tenant_id', auth()->user()->tenant_id);
        }

        $streamers = $query->paginate(20);
        return view('admin.streamers.index', compact('streamers'));
    }

    public function create()
    {
        abort_if(!auth()->user()->isAdmin(), 403);

        return view('admin.streamers.create', [
            'tenants' => Tenant::all(),
            'stations' => Station::all(),
        ]);
    }

    public function store(Request $request)
    {
        abort_if(!auth()->user()->isAdmin(), 403);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'handle' => 'required|string|max:255|unique:streamers,handle',
            'status' => 'required|in:live,offline,away',
            'tenant_id' => 'nullable|exists:tenants,id',
            'station_id' => 'nullable|exists:stations,id',
            'bio' => 'nullable|string',
        ]);

        Streamer::create($data);

        return redirect()->route('admin.streamers.index')->with('status', 'Streamer created.');
    }

    public function edit(Streamer $streamer)
    {
        abort_if(!auth()->user()->isAdmin(), 403);

        return view('admin.streamers.edit', [
            'streamer' => $streamer,
            'tenants' => Tenant::all(),
            'stations' => Station::all(),
        ]);
    }

    public function update(Request $request, Streamer $streamer)
    {
        abort_if(!auth()->user()->isAdmin(), 403);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'handle' => 'required|string|max:255|unique:streamers,handle,' . $streamer->id,
            'status' => 'required|in:live,offline,away',
            'tenant_id' => 'nullable|exists:tenants,id',
            'station_id' => 'nullable|exists:stations,id',
            'bio' => 'nullable|string',
        ]);

        $streamer->update($data);

        return redirect()->route('admin.streamers.index')->with('status', 'Streamer updated.');
    }

    public function destroy(Streamer $streamer)
    {
        abort_if(!auth()->user()->isAdmin(), 403);

        $streamer->delete();

        return back()->with('status', 'Streamer removed.');
    }
}
