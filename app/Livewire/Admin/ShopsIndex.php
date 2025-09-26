<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Shop;
use App\Models\User;

class ShopsIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'tailwind';

    public $search = '';
    public $statusFilter = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function approveShop($id)
    {
        $shop = Shop::findOrFail($id);
        $shop->status = 'approved';
        $shop->save();

        session()->flash('message', 'Shop approved successfully!');
    }

    public function blockShop($id)
    {
        $shop = Shop::findOrFail($id);
        $shop->status = 'blocked';
        $shop->save();

        session()->flash('message', 'Shop blocked successfully!');
    }

    public function deleteShop($id)
    {
        $shop = Shop::findOrFail($id);
        $shop->delete();

        session()->flash('message', 'Shop deleted successfully!');
    }

    public function render()
    {
        $shops = Shop::with('user')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                      ->orWhereHas('user', function ($q) {
                          $q->where('name', 'like', "%{$this->search}%");
                      });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.shops-index', [
            'shops' => $shops
        ]) ->layout('layouts.app');
    }
}
