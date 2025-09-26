<?php

namespace App\Livewire\Vendor;

use Livewire\Component;
use App\Models\SupportTicket;
use Illuminate\Support\Facades\Auth;

class Support extends Component
{
    public $subject;
    public $message;
    public $tickets;

    public function mount()
    {
        $this->loadTickets();
    }

    public function loadTickets()
    {
        $this->tickets = SupportTicket::where('user_id', Auth::id())
                                      ->orderBy('created_at', 'desc')
                                      ->get();
    }

    public function submitTicket()
    {
        $this->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        SupportTicket::create([
            'user_id' => Auth::id(),
            'subject' => $this->subject,
            'message' => $this->message,
            'status' => 'open',
        ]);

        $this->subject = '';
        $this->message = '';
        $this->loadTickets();

        session()->flash('success', 'Support ticket submitted successfully!');
    }

    public function render()
    {
        return view('livewire.vendor.support')
               ->layout('layouts.app');
    }
}
