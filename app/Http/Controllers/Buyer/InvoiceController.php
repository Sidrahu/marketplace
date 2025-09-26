<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use App\Models\Invoice;

#[\Illuminate\Routing\Attributes\Middleware('auth')]
class InvoiceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $invoices = Invoice::where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('buyer.invoices', compact('invoices'));
    }

    public function download(Invoice $invoice)
    {
        if ($invoice->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized access.');
        }

        if (!empty($invoice->path) && Storage::disk('public')->exists($invoice->path)) {
            $filename = Str::slug($invoice->invoice_number ?: "invoice-{$invoice->id}") . '.pdf';
            return Storage::disk('public')->download($invoice->path, $filename);
        }

        try {
            $pdf = Pdf::loadView('invoices.pdf', ['invoice' => $invoice]);
            $filename = Str::slug($invoice->invoice_number ?: "invoice-{$invoice->id}") . '.pdf';
            return $pdf->download($filename);
        } catch (\Throwable $e) {
            \Log::error('Invoice PDF generation failed: '.$e->getMessage(), ['invoice_id' => $invoice->id]);
            abort(500, 'Could not generate invoice PDF. Please try again later.');
        }
    }
}
