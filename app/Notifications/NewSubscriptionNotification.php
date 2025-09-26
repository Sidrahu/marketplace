<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewSubscriptionNotification extends Notification
{
    use Queueable;
  

    public $buyer;
    public $product;

    /**
     * Create a new notification instance.
     */
    public function __construct($buyer, $product)
    {
        $this->buyer = $buyer;
        $this->product = $product;
    }
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
   public function toDatabase($notifiable)
    {
        return [
            'buyer_name' => $this->buyer->name,
            'buyer_id' => $this->buyer->id,
            'product_name' => $this->product->name,
            'product_id' => $this->product->id,
            'message' => "{$this->buyer->name} has subscribed to your product: {$this->product->name}.",
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
           
        ];
    }
}
