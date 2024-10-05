<?php

namespace App\Http\Controllers;

use App\Models\EmployerSubscription;
use App\Models\Employer;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EmployerSubscriptionController extends Controller
{
    // Show available subscription plans for employers
    public function showPlans()
    {
        $plans = [
            ['name' => 'Weekly Plan', 'price' => 250, 'duration' => '1 week'],
            ['name' => 'Bi-Weekly Plan', 'price' => 500, 'duration' => '2 weeks'],
            ['name' => 'Monthly Plan', 'price' => 1000, 'duration' => '1 month'],
        ];

        return view('employer.subscriptions.plans', compact('plans'));
    }

    // Subscribe to a plan
    public function subscribe(Request $request)
    {
        $planName = $request->input('plan');
        $price = $request->input('price');
        $duration = $request->input('duration');

        $startDate = Carbon::now();
        $endDate = Carbon::now()->add($duration);

        $subscription = new EmployerSubscription();
        $subscription->employer_id = auth()->id(); // Assuming employer is authenticated
        $subscription->plan_name = $planName;
        $subscription->price = $price;
        $subscription->start_date = $startDate;
        $subscription->end_date = $endDate;
        $subscription->save();

        return redirect()->route('employer.subscriptions.active')->with('success', 'Subscription successful!');
    }

    // Show active subscriptions for the employer
    public function activeSubscriptions()
    {
        $employer = Employer::find(auth()->id());
        $subscriptions = $employer->subscriptions()->latest()->get();

        return view('employer.subscriptions.active', compact('subscriptions'));
    }
}
