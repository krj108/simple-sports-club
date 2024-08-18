<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    // Retrieve a list of all subscriptions
    public function index()
    {
        return Subscription::all();
    }

    // Create a new subscription
    public function store(Request $request)
    {
        $subscription = Subscription::create($request->all());
        return response()->json($subscription, 201);
    }

    // Update an existing subscription
    public function update(Request $request, Subscription $subscription)
    {
        $subscription->update($request->all());
        return response()->json($subscription, 200);
    }

    // Delete a specific subscription
    public function destroy(Subscription $subscription)
    {
        $subscription->delete();
        return response()->json(null, 204);
    }

    // Approve a subscription
    public function approve(Subscription $subscription)
    {
        $subscription->update(['status' => 'approved']);
        return response()->json($subscription, 200);
    }

    // Suspend a subscription with an optional reason
    public function suspend(Subscription $subscription, Request $request)
    {
        $subscription->update(['status' => 'suspended', 'reason' => $request->reason]);
        return response()->json($subscription, 200);
    }

    // Renew a subscription
    public function renew(Subscription $subscription)
    {
        $subscription->update(['status' => 'renewed']);
        return response()->json($subscription, 200);
    }

    // Apply discount to a subscription
    public function applyDiscount(Request $request, Subscription $subscription)
    {
        $request->validate([
            'discount' => 'required|numeric|min:0|max:100',
        ]);

        $subscription->update(['discount' => $request->discount]);
        return response()->json($subscription, 200);
    }
}

