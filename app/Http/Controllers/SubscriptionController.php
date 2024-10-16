<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Writer;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    public function showPlans()
    {
        $plans = [
            ['name' => 'Weekly Plan', 'price' => 125, 'duration' => '1 week'],
            ['name' => 'Bi-Weekly Plan', 'price' => 250, 'duration' => '2 weeks'],
            ['name' => 'Monthly Plan', 'price' => 500, 'duration' => '1 month'],
        ];

        $writer = Writer::find(auth()->id());
        $balance = $writer->balance;

        return view('subscriptions.plans', compact('plans', 'balance'));
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'plan' => 'required|string',
            'price' => 'required|numeric',
            'duration' => 'required|string',
        ]);

        $planName = $request->input('plan');
        $price = $request->input('price');
        $duration = $request->input('duration');

        $writer = Writer::find(auth()->id());

        // Check if the writer has sufficient balance
        if ($writer->balance < $price) {
            return redirect()->back()->with('error', 'Insufficient balance for this subscription.');
        }

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Deduct the price from the writer's balance
            $writer->decrement('balance', $price);

            // Handle date calculation
            $startDate = Carbon::now();
            $endDate = Carbon::now()->add(str_replace(' ', '', $duration));

            // Check if there's an existing active subscription
            $existingSubscription = $writer->subscriptions()
                ->where('end_date', '>', now())
                ->latest()
                ->first();

            if ($existingSubscription) {
                // Update existing subscription
                $existingSubscription->update([
                    'plan_name' => $planName,
                    'price' => $price,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                ]);
                $subscription = $existingSubscription;
            } else {
                // Create new subscription
                $subscription = new Subscription([
                    'writer_id' => $writer->id,
                    'plan_name' => $planName,
                    'price' => $price,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                ]);
                $subscription->save();
            }

            DB::commit();

            return redirect()->route('subscriptions.active')->with('success', 'Subscription successful!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while processing your subscription. Please try again.');
        }
    }

    public function activeSubscriptions()
    {
        $writer = Writer::find(auth()->id());
        $subscriptions = $writer->subscriptions()->latest()->get();

        return view('subscriptions.active', compact('subscriptions'));
    }
}
