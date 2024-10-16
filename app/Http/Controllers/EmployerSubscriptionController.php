<?php

namespace App\Http\Controllers;

use App\Models\EmployerSubscription;
use App\Models\Employer;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

        $wallet = Wallet::firstOrCreate(['employer_id' => auth()->id()]);

        return view('employer.subscriptions.plans', compact('plans', 'wallet'));
    }

    // Subscribe to a plan
    public function subscribe(Request $request)
    {
        $planName = $request->input('plan');
        $price = $request->input('price');
        $duration = $request->input('duration');

        $wallet = Wallet::where('employer_id', auth()->id())->first();

        if (!$wallet || $wallet->balance < $price) {
            return redirect()->route('employer.subscriptions.plans')->with('error', 'Insufficient balance. Please add funds to your wallet.');
        }

        DB::beginTransaction();

        try {
            $startDate = Carbon::now();
            $endDate = Carbon::now()->add($duration);

            $existingSubscription = EmployerSubscription::where('employer_id', auth()->id())
                ->where('end_date', '>', now())
                ->first();

            if ($existingSubscription) {
                // Update existing subscription
                $existingSubscription->end_date = $endDate;
                $existingSubscription->save();
            } else {
                // Create new subscription
                $subscription = new EmployerSubscription();
                $subscription->employer_id = auth()->id();
                $subscription->plan_name = $planName;
                $subscription->price = $price;
                $subscription->start_date = $startDate;
                $subscription->end_date = $endDate;
                $subscription->save();
            }

            // Deduct the price from the wallet
            $wallet->balance -= $price;
            $wallet->save();

            DB::commit();

            return redirect()->route('employer.subscriptions.active')->with('success', 'Subscription successful!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('employer.subscriptions.plans')->with('error', 'An error occurred. Please try again.');
        }
    }

    // Show active subscriptions for the employer
    public function activeSubscriptions()
    {
        $employer = Employer::find(auth()->id());
        $subscriptions = $employer->subscriptions()->latest()->get();

        return view('employer.subscriptions.active', compact('subscriptions'));
    }
}
