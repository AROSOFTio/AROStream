<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $tenants = $user->isAdmin()
            ? Tenant::latest()->paginate(20)
            : Tenant::where('id', $user->tenant_id)->paginate(20);

        return view('admin.tenants.index', compact('tenants'));
    }

    public function show(Tenant $tenant)
    {
        $this->authorize('view', $tenant);

        $tenant->load('stations');
        return view('admin.tenants.show', compact('tenant'));
    }

    public function create()
    {
        abort_if(!auth()->user()->isAdmin(), 403);

        return view('admin.tenants.create');
    }

    public function store(Request $request)
    {
        abort_if(!auth()->user()->isAdmin(), 403);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'contact_name' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'status' => 'required|in:active,trial,suspended',
        ]);

        Tenant::create($data);

        return redirect()->route('admin.tenants.index')->with('status', 'Tenant created.');
    }

    public function edit(Tenant $tenant)
    {
        abort_if(!auth()->user()->isAdmin(), 403);

        return view('admin.tenants.edit', compact('tenant'));
    }

    public function update(Request $request, Tenant $tenant)
    {
        abort_if(!auth()->user()->isAdmin(), 403);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'contact_name' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'status' => 'required|in:active,trial,suspended',
        ]);

        $tenant->update($data);

        return redirect()->route('admin.tenants.index')->with('status', 'Tenant updated.');
    }

    public function destroy(Tenant $tenant)
    {
        abort_if(!auth()->user()->isAdmin(), 403);

        $tenant->delete();

        return back()->with('status', 'Tenant deleted.');
    }
}
