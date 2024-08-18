<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription; // استيراد مودل Subscription

class SubscriptionController extends Controller
{
    public function store(Request $request)
    {
       
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
        ]);

       
        Subscription::create($validatedData);

        return redirect()->back()->with('success', 'Subscription request submitted successfully!');
    }
}
