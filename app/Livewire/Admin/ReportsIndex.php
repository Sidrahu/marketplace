<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Order;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;

class ReportsIndex extends Component
{
    public $month;
    public $year;
    public $totalOrders;
    public $totalRevenue;
    public $activeSubscriptions;
    public $newUsers;

    public function mount()
    {
        $this->month = Carbon::now()->month;
        $this->year  = Carbon::now()->year;
        $this->loadReports();
    }

    public function updatedMonth()
    {
        $this->loadReports();
    }

    public function updatedYear()
    {
        $this->loadReports();
    }

    public function loadReports()
    {
        $startDate = Carbon::create($this->year, $this->month)->startOfMonth();
        $endDate   = Carbon::create($this->year, $this->month)->endOfMonth();

        // Total Orders
        $this->totalOrders = Order::whereBetween('created_at', [$startDate, $endDate])->count();

        // Total Revenue
        $this->totalRevenue = Order::whereBetween('created_at', [$startDate, $endDate])->sum('total_price');

        // Active Subscriptions
        $this->activeSubscriptions = Subscription::where('status', 'active')->count();

        // New Users Registered
        $this->newUsers = User::whereBetween('created_at', [$startDate, $endDate])->count();
    }

    public function render()
    {
        return view('livewire.admin.reports-index')
         ->layout('layouts.app');
    }
}
