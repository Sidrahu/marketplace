<?php

namespace App\Livewire\Vendor;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class SalesReports extends Component
{
    public $orders;
    public $totalSales = 0;

    public function mount()
    {
        // Vendor ke orders load karo
        $this->orders = Order::where('vendor_id', Auth::id())->get();
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->totalSales = $this->orders->sum('total_price');
    }

    public function render()
    {
        return view('livewire.vendor.sales-reports')
            ->layout('layouts.app');
    }
}
