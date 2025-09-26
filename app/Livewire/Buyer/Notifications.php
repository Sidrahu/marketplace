<?php
namespace App\Livewire\Buyer;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Notifications extends Component
{
    public $notifications = [];
    public $listeners = [];

    public function mount()
    {
        $this->notifications = Auth::user()->unreadNotifications()->get()->toArray();

        $userId = Auth::id();
        if ($userId) {
            $this->listeners = [
                "echo:private-App.Models.User.$userId,OrderStatusUpdated" => 'handleOrderStatusUpdated',
            ];
        }
    }

    public function handleOrderStatusUpdated($payload)
    {
        $this->notifications[] = $payload;
        $this->dispatchBrowserEvent('notify', ['message' => $payload['message']]);
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
            $this->notifications = Auth::user()->unreadNotifications()->get()->toArray();
        }
    }

    public function render()
    {
        return view('livewire.buyer.notifications')
         ->layout('layouts.app');
    }
 }
