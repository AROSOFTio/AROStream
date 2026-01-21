<aside class="w-64 bg-slate-900 text-slate-100 min-h-screen flex flex-col">
    <div class="px-6 py-5 border-b border-slate-800">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <span class="inline-flex h-10 w-10 items-center justify-center rounded bg-orange-500 text-slate-900 font-bold">AS</span>
            <div>
                <div class="text-lg font-semibold">{{ $appSettings['brand_name'] ?? 'AROStream' }}</div>
                <div class="text-xs text-slate-400">{{ $appSettings['brand_tagline'] ?? 'Number one streaming software in the world' }}</div>
            </div>
        </a>
    </div>

    <nav class="flex-1 px-4 py-4 space-y-1 text-sm">
        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded {{ request()->routeIs('admin.dashboard') ? 'bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800' }}">Overview</a>
            <a href="{{ route('admin.guide') }}" class="block px-3 py-2 rounded {{ request()->routeIs('admin.guide') ? 'bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800' }}">Guide</a>
            <a href="{{ route('admin.stations.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('admin.stations.*') ? 'bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800' }}">Stations</a>
            <a href="{{ route('admin.tenants.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('admin.tenants.*') ? 'bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800' }}">Tenants</a>
            <a href="{{ route('admin.streamers.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('admin.streamers.*') ? 'bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800' }}">Streamers</a>
            <a href="{{ route('admin.sessions.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('admin.sessions.*') ? 'bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800' }}">Live Sessions</a>
            <a href="{{ route('admin.nodes.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('admin.nodes.*') ? 'bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800' }}">Nodes</a>
            <a href="{{ route('admin.domains.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('admin.domains.*') ? 'bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800' }}">Domains</a>
            <a href="{{ route('admin.subscriptions.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('admin.subscriptions.*') ? 'bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800' }}">Billing</a>
            <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('admin.users.*') ? 'bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800' }}">Users</a>
            <a href="{{ route('admin.settings.edit') }}" class="block px-3 py-2 rounded {{ request()->routeIs('admin.settings.*') ? 'bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800' }}">Settings</a>
        @else
            <a href="{{ route('tenant.dashboard') }}" class="block px-3 py-2 rounded {{ request()->routeIs('tenant.dashboard') ? 'bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800' }}">Overview</a>
            <a href="{{ route('tenant.guide') }}" class="block px-3 py-2 rounded {{ request()->routeIs('tenant.guide') ? 'bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800' }}">Guide</a>
            <a href="{{ route('admin.stations.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('admin.stations.*') ? 'bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800' }}">Stations</a>
            <a href="{{ route('admin.streamers.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('admin.streamers.*') ? 'bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800' }}">Streamers</a>
            <a href="{{ route('admin.sessions.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('admin.sessions.*') ? 'bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800' }}">Live Sessions</a>
            <a href="{{ route('tenant.settings.edit') }}" class="block px-3 py-2 rounded {{ request()->routeIs('tenant.settings.*') ? 'bg-slate-800 text-white' : 'text-slate-300 hover:bg-slate-800' }}">Settings</a>
        @endif
    </nav>

    <div class="px-4 py-4 border-t border-slate-800">
        <div class="text-xs text-slate-400 mb-2">Signed in as</div>
        <div class="text-sm font-semibold">{{ Auth::user()->name }}</div>
        <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button type="submit" class="w-full px-3 py-2 rounded bg-slate-800 text-slate-200 hover:bg-slate-700">Log Out</button>
        </form>
    </div>
</aside>
