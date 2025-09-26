<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Order;   

class OrdersInvoices extends Component
{
   public $orders;

    public function mount()
    {
        $this->loadOrders();
    }

    public function loadOrders()
    {
        $this->orders = Order::with(['buyer', 'vendor', 'product'])->get();
    }

    public function render()
    {
        return view('livewire.admin.orders-invoices')
          ->layout('layouts.app');
    }
}
