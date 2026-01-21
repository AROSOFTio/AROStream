<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Services\Billing\RenewalService;

class SubscriptionController extends Controller
{
    public function index()
    {
        abort_if(!auth()->user()->isAdmin(), 403);
        $subscriptions = Subscription::with('station')->paginate(30);
        return view('admin.subscriptions.index', compact('subscriptions'));
    }

    public function edit(Subscription $subscription)
    {
        abort_if(!auth()->user()->isAdmin(), 403);

        return view('admin.subscriptions.edit', compact('subscription'));
    }

    public function update(Subscription $subscription)
    {
        abort_if(!auth()->user()->isAdmin(), 403);

        $data = request()->validate([
            'plan' => 'required|in:basic,standard,pro',
            'status' => 'required|in:active,past_due,cancelled',
            'renews_at' => 'required|date',
        ]);

        $subscription->update($data);

        return redirect()->route('admin.subscriptions.index')->with('status', 'Subscription updated.');
    }

    public function extend(Subscription $subscription, RenewalService $renewal)
    {
        abort_if(!auth()->user()->isAdmin(), 403);
        $renewal->extendOneYear($subscription);

        return back()->with('status', 'Subscription extended by 1 year.');
    }

    public function destroy(Subscription $subscription)
    {
        abort_if(!auth()->user()->isAdmin(), 403);

        $subscription->delete();

        return back()->with('status', 'Subscription deleted.');
    }
}
