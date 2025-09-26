<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public $totalBuyers;
    public $totalVendors;
    public $totalOrders;
    public $pendingOrders;
    public $completedOrders;
    public $cancelledOrders;
    public $totalRevenue;
    public $latestOrders;
    public $topVendors;

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        // Buyers and Vendors count (agar spatie roles use ho rahe hain)
        $this->totalBuyers = User::role('buyer')->count();
        $this->totalVendors = User::role('seller')->count();

        // Orders count
        $this->totalOrders = Order::count();
        $this->pendingOrders = Order::where('status', 'pending')->count();
        $this->completedOrders = Order::where('status', 'completed')->count();
        $this->cancelledOrders = Order::where('status', 'cancelled')->count();

        // Revenue
        $this->totalRevenue = Order::where('status', 'completed')->sum('total_price');

        // Latest Orders
        $this->latestOrders = Order::with('buyer')
            ->latest()
            ->take(5)
            ->get();

        // Top Vendors (total sales ke hisaab se)
        $this->topVendors = User::role('seller')
            ->select('users.id', 'users.name', DB::raw('SUM(orders.total_price) as total_sales'))
            ->join('orders', 'orders.vendor_id', '=', 'users.id')
            ->where('orders.status', 'completed')
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total_sales')
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.dashboard')
            ->layout('layouts.app');
    }
}
