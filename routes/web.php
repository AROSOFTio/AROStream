<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\DomainController;
use App\Http\Controllers\Admin\NodeController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\StationController;
use App\Http\Controllers\Admin\StreamSessionController;
use App\Http\Controllers\Admin\StreamerController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\TenantController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Tenant\TenantDashboardController;
use App\Http\Controllers\Tenant\TenantSettingsController;
use App\Models\StreamSession;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

Route::get('/', function () {
    $liveSessions = collect();

    if (Schema::hasTable('stream_sessions')) {
        $liveSessions = StreamSession::with(['station', 'streamer'])
            ->where('status', 'live')
            ->orderByDesc('listeners_current')
            ->limit(6)
            ->get();
    }

    return view('landing', compact('liveSessions'));
})->name('landing');

Route::get('/dashboard', function () {
    return auth()->user()?->isAdmin()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('tenant.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::view('/guide', 'guide')->name('guide');

    Route::get('/tenants', [TenantController::class, 'index'])->name('tenants.index');
    Route::get('/tenants/create', [TenantController::class, 'create'])->name('tenants.create');
    Route::post('/tenants', [TenantController::class, 'store'])->name('tenants.store');
    Route::get('/tenants/{tenant}', [TenantController::class, 'show'])->name('tenants.show');
    Route::get('/tenants/{tenant}/edit', [TenantController::class, 'edit'])->name('tenants.edit');
    Route::put('/tenants/{tenant}', [TenantController::class, 'update'])->name('tenants.update');
    Route::delete('/tenants/{tenant}', [TenantController::class, 'destroy'])->name('tenants.destroy');

    Route::get('/stations', [StationController::class, 'index'])->name('stations.index');
    Route::get('/stations/create', [StationController::class, 'create'])->name('stations.create');
    Route::post('/stations', [StationController::class, 'store'])->name('stations.store');
    Route::get('/stations/{station}', [StationController::class, 'show'])->name('stations.show');
    Route::get('/stations/{station}/go-live', [StationController::class, 'goLive'])->name('stations.go-live');
    Route::get('/stations/{station}/edit', [StationController::class, 'edit'])->name('stations.edit');
    Route::put('/stations/{station}', [StationController::class, 'update'])->name('stations.update');
    Route::post('/stations/{station}/suspend', [StationController::class, 'suspend'])->name('stations.suspend');
    Route::post('/stations/{station}/resume', [StationController::class, 'resume'])->name('stations.resume');

    Route::get('/domains', [DomainController::class, 'index'])->name('domains.index');
    Route::get('/domains/create', [DomainController::class, 'create'])->name('domains.create');
    Route::post('/domains', [DomainController::class, 'store'])->name('domains.store');
    Route::post('/domains/{domain}/verify', [DomainController::class, 'verify'])->name('domains.verify');
    Route::get('/domains/{domain}/edit', [DomainController::class, 'edit'])->name('domains.edit');
    Route::put('/domains/{domain}', [DomainController::class, 'update'])->name('domains.update');
    Route::delete('/domains/{domain}', [DomainController::class, 'destroy'])->name('domains.destroy');

    Route::get('/nodes', [NodeController::class, 'index'])->name('nodes.index');
    Route::post('/nodes', [NodeController::class, 'store'])->name('nodes.store');
    Route::get('/nodes/{node}/edit', [NodeController::class, 'edit'])->name('nodes.edit');
    Route::put('/nodes/{node}', [NodeController::class, 'update'])->name('nodes.update');
    Route::delete('/nodes/{node}', [NodeController::class, 'destroy'])->name('nodes.destroy');

    Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::post('/subscriptions/{subscription}/extend', [SubscriptionController::class, 'extend'])->name('subscriptions.extend');
    Route::get('/subscriptions/{subscription}/edit', [SubscriptionController::class, 'edit'])->name('subscriptions.edit');
    Route::put('/subscriptions/{subscription}', [SubscriptionController::class, 'update'])->name('subscriptions.update');
    Route::delete('/subscriptions/{subscription}', [SubscriptionController::class, 'destroy'])->name('subscriptions.destroy');

    Route::get('/streamers', [StreamerController::class, 'index'])->name('streamers.index');
    Route::get('/streamers/create', [StreamerController::class, 'create'])->name('streamers.create');
    Route::post('/streamers', [StreamerController::class, 'store'])->name('streamers.store');
    Route::get('/streamers/{streamer}/edit', [StreamerController::class, 'edit'])->name('streamers.edit');
    Route::put('/streamers/{streamer}', [StreamerController::class, 'update'])->name('streamers.update');
    Route::delete('/streamers/{streamer}', [StreamerController::class, 'destroy'])->name('streamers.destroy');

    Route::get('/sessions', [StreamSessionController::class, 'index'])->name('sessions.index');
    Route::get('/sessions/{session}', [StreamSessionController::class, 'show'])->name('sessions.show');

    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

Route::middleware(['auth'])->prefix('tenant')->name('tenant.')->group(function () {
    Route::get('/dashboard', [TenantDashboardController::class, 'index'])->name('dashboard');
    Route::get('/settings', [TenantSettingsController::class, 'edit'])->name('settings.edit');
    Route::post('/settings', [TenantSettingsController::class, 'update'])->name('settings.update');
    Route::get('/stations/{station}/go-live', [StationController::class, 'goLive'])->name('stations.go-live');
    Route::view('/guide', 'guide')->name('guide');
});

require __DIR__.'/auth.php';
