<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class WebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->server('HTTP_STRIPE_SIGNATURE');
        $endpoint_secret = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, 
                $sig_header, 
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            Log::error("Stripe Webhook Error: Invalid payload");
            return response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::error("Stripe Webhook Error: Invalid signature");
            return response('Invalid signature', 400);
        }

        // ✅ Check checkout complete event
        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            Log::info("Stripe Checkout Session Completed: ", (array) $session);

            if (!isset($session->metadata->user_id)) {
                Log::error("User ID missing in session metadata");
                return response('User ID missing', 400);
            }

            $user = User::find($session->metadata->user_id);

            if ($user) {
                $cartItems = $user->carts()->with('product')->get();

                if ($cartItems->isEmpty()) {
                    Log::warning("No cart items found for user: {$user->id}");
                    return response('No cart items', 200);
                }

                $totalAmount = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

                if ($totalAmount > 0) {
                    // ✅ Invoice create
                    $invoice = Invoice::create([
                        'user_id'        => $user->id,
                        'amount'         => $totalAmount,
                        'invoice_number' => 'INV-' . strtoupper(uniqid()),
                        'status'         => 'paid',
                         'details' => 'Order details or some JSON/text here', 
                        
 

                    ]);

                    // ✅ PDF generate
                    $filename = 'invoices/' . $invoice->invoice_number . '.pdf';
                    $pdf = Pdf::loadView('invoices.template', [
                        'invoice'   => $invoice,
                        'cartItems' => $cartItems
                    ]);
                    Storage::disk('public')->put($filename, $pdf->output());

                    $invoice->update(['path' => $filename]);

                    // ✅ Clear cart
                    $user->carts()->delete();

                    Log::info("Invoice {$invoice->invoice_number} created for user {$user->id}");
                }
            }
        }

        return response('Webhook handled', 200);
    }
}
