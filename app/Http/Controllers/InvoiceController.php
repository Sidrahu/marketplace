<?php

// app/Http/Controllers/InvoiceController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use PDF;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function download(Invoice $invoice)
    {
        
        if ($invoice->user_id !== Auth::id()) {
            abort(403);
        }

        
        $cartItems = $invoice->user->carts()->with('product')->get(); 
        

        $pdf = PDF::loadView('invoices.pdf', compact('invoice', 'cartItems'));

        
        return $pdf->download($invoice->invoice_number . '.pdf');
    }
}
