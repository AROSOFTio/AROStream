<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Node;
use Illuminate\Http\Request;

class NodeController extends Controller
{
    public function index()
    {
        abort_if(!auth()->user()->isAdmin(), 403);
        $nodes = Node::paginate(20);
        return view('admin.nodes.index', compact('nodes'));
    }

    public function store(Request $request)
    {
        abort_if(!$request->user()->isAdmin(), 403);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'base_url' => 'required|url',
            'shared_secret' => 'required|string',
            'capacity_stations' => 'nullable|integer',
            'capacity_listeners' => 'nullable|integer',
            'status' => 'nullable|in:active,maintenance,offline',
        ]);

        Node::create($data);

        return back()->with('status', 'Node created.');
    }

    public function edit(Node $node)
    {
        abort_if(!auth()->user()->isAdmin(), 403);

        return view('admin.nodes.edit', compact('node'));
    }

    public function update(Request $request, Node $node)
    {
        abort_if(!$request->user()->isAdmin(), 403);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'base_url' => 'required|url',
            'shared_secret' => 'required|string',
            'capacity_stations' => 'nullable|integer',
            'capacity_listeners' => 'nullable|integer',
            'status' => 'nullable|in:active,maintenance,offline',
        ]);

        $node->update($data);

        return redirect()->route('admin.nodes.index')->with('status', 'Node updated.');
    }

    public function destroy(Node $node)
    {
        abort_if(!auth()->user()->isAdmin(), 403);

        $node->delete();

        return back()->with('status', 'Node deleted.');
    }
}
