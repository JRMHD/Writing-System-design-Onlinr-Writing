<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Writer;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    // Show available subscription plans
    public function showPlans()
    {
        $plans = [
            ['name' => 'Weekly Plan', 'price' => 125, 'duration' => '1 week'],
            ['name' => 'Bi-Weekly Plan', 'price' => 250, 'duration' => '2 weeks'],
            ['name' => 'Monthly Plan', 'price' => 500, 'duration' => '1 month'],
        ];

        return view('subscriptions.plans', compact('plans'));
    }

    // Subscribe to a plan
    public function subscribe(Request $request)
    {
        $request->validate([
            'plan' => 'required|string',
            'price' => 'required|numeric',
            'duration' => 'required|string',
            'phone' => 'required|string|max:15'  // Validate phone number
        ]);

        $planName = $request->input('plan');
        $price = $request->input('price');
        $duration = $request->input('duration');
        $phone = $request->input('phone');  // Capture phone number

        // Handle date calculation
        $startDate = Carbon::now();
        $endDate = Carbon::now()->add(str_replace(' ', '', $duration));  // Add duration to current date

        // Create new subscription
        $subscription = new Subscription();
        $subscription->writer_id = auth()->id();
        $subscription->plan_name = $planName;
        $subscription->price = $price;
        $subscription->phone = $phone;  // Store phone number
        $subscription->start_date = $startDate;
        $subscription->end_date = $endDate;
        $subscription->save();

        return redirect()->route('subscriptions.active')->with('success', 'Subscription successful!');
    }

    // Show active subscriptions
    public function activeSubscriptions()
    {
        $writer = Writer::find(auth()->id());
        $subscriptions = $writer->subscriptions()->latest()->get();

        return view('subscriptions.active', compact('subscriptions'));
    }
}
