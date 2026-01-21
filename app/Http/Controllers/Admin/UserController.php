<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        abort_if(!auth()->user()->isAdmin(), 403);

        $users = User::with('tenant')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        abort_if(!auth()->user()->isAdmin(), 403);

        return view('admin.users.create', [
            'tenants' => Tenant::all(),
        ]);
    }

    public function store(Request $request)
    {
        abort_if(!auth()->user()->isAdmin(), 403);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,customer',
            'tenant_id' => 'nullable|exists:tenants,id',
        ]);

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('admin.users.index')->with('status', 'User created.');
    }

    public function edit(User $user)
    {
        abort_if(!auth()->user()->isAdmin(), 403);

        return view('admin.users.edit', [
            'user' => $user,
            'tenants' => Tenant::all(),
        ]);
    }

    public function update(Request $request, User $user)
    {
        abort_if(!auth()->user()->isAdmin(), 403);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:admin,customer',
            'tenant_id' => 'nullable|exists:tenants,id',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('status', 'User updated.');
    }

    public function destroy(User $user)
    {
        abort_if(!auth()->user()->isAdmin(), 403);

        $user->delete();

        return back()->with('status', 'User deleted.');
    }
}
