<?php

namespace App\Livewire\Buyer;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationsDropdown extends Component
{
    public $notifications;
    public $unreadCount = 0;

    protected function getListeners()
    {
        return [
            "echo:private-user." . auth()->id() . ",.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated" => 'loadNotifications'
        ];
    }

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $user = Auth::user();
        if (!$user) {
            $this->notifications = collect();
            $this->unreadCount = 0;
            return;
        }

        $this->notifications = $user->notifications()->latest()->limit(20)->get();
        $this->unreadCount = $user->unreadNotifications()->count();
    }

    public function markAsRead($uuid)
    {
        $user = Auth::user();
        $notification = $user->notifications()->where('id', $uuid)->first();
        if ($notification) {
            $notification->markAsRead();
            $this->loadNotifications();
        }
    }

    public function markAllAsRead()
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();
        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.buyer.notifications-dropdown')
            ->layout('layouts.app');
    }
}
