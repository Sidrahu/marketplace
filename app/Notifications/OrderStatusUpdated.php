<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;  // <-- Import karo ye
use Illuminate\Notifications\Notification;
use App\Models\Order;   

class OrderStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    public $order;
    public $message;

    /**
     * Create a new notification instance.
     */
   public function __construct($order, $message = null)
    {
        $this->order = $order;
        $this->message = $message ?? "Your order #{$order->id} status changed to {$order->status}";
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
{
    return ['database', 'broadcast']; // database + real-time
}


    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Order Status Updated')
            ->line("Your order #{$this->order->id} status has been updated to: {$this->order->status}.")
            ->action('View Order', url('/buyer/orders/'.$this->order->id))
            ->line('Thank you for shopping with us!');
    }

    /**
     * Get the array representation of the notification.
     */
     public function toArray($notifiable)
{
    return [
        'order_id'     => $this->order->id,
        'status'       => $this->order->status,
        'product_name' => optional($this->order->product)->name,
        'seller_name'  => optional($this->order->vendor)->name,
        'message'      => $this->message,
        'timestamp'    => now()->toDateTimeString(),
    ];
}

    /**
     * Data saved in database notification.
     */
    public function toDatabase($notifiable)
    {
        return [
            'order_id'     => $this->order->id,
            'status'       => $this->order->status,
            'product_name' => optional($this->order->product)->name,
            'seller_name'  => optional($this->order->seller)->name,
            'message'      => $this->message,
            'timestamp'    => now()->toDateTimeString(),
        ];
    }
    /**
     * Data sent over broadcast channel (real-time).
     */
    public function toBroadcast($notifiable)
{
    return new BroadcastMessage($this->toArray($notifiable));
}
}
