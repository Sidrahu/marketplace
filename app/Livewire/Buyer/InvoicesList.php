<?php

namespace App\Livewire\Buyer;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;

class InvoicesList extends Component
{
    public $invoices;

    public function mount()
    {
        $this->loadInvoices();
    }

    public function loadInvoices()
    {
       $this->invoices = Invoice::with('order.product')
                        ->where('user_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->get();

    }

    public function render()
    {
        return view('livewire.buyer.invoices-list')
                ->layout('layouts.app');
    }
}
