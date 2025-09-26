<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ProductUser;
use App\Models\Invoice;
use Stripe\StripeClient;

class ProcessScheduledBilling extends Command
{
    protected $signature = 'billing:process';
    protected $description = 'Process scheduled billing for subscriptions';

    public function handle()
    {
        $stripe = new StripeClient(env('STRIPE_SECRET'));

        // Sirf active subscriptions jinke billing date ab ya pehle hai
        $subscriptions = ProductUser::where('next_billing_date', '<=', now())
                                    ->where('status', 'active')
                                    ->get();

        foreach ($subscriptions as $subscription) {
            try {
                $charge = $stripe->paymentIntents->create([
                    'amount' => $subscription->amount * 100, // cents
                    'currency' => 'usd',
                    'customer' => $subscription->stripe_customer_id,
                    'payment_method' => $subscription->stripe_payment_method_id,
                    'off_session' => true,
                    'confirm' => true,
                ]);

                if ($charge->status == 'succeeded') {
                    // Next billing date update (1 month aage)
                    $subscription->next_billing_date = now()->addMonth();
                    $subscription->save();

                    // Invoice create karo
                    Invoice::create([
                        'user_id' => $subscription->user_id,
                        'invoice_number' => Invoice::generateInvoiceNumber(),
                        'amount' => $subscription->amount,
                        'status' => 'paid',
                        'details' => ['subscription_id' => $subscription->id],
                    ]);

                    $this->info("Subscription {$subscription->id} billed successfully.");
                }
            } catch (\Exception $e) {
                $this->error("Failed to bill subscription {$subscription->id}: {$e->getMessage()}");
                // Yahan aap notification ya logging kar sakte hain agar chahen
            }
        }
    }
}
