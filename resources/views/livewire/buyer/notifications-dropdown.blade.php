<div class="relative">
    <button class="px-4 py-2 bg-gray-800 text-white rounded">
        Notifications ({{ $unreadCount }})
    </button>
    <div class="absolute right-0 mt-2 w-80 bg-white shadow-lg border rounded">
        <div class="flex justify-between p-2 border-b">
            <strong>Notifications</strong>
            @if($unreadCount)
                <button wire:click="markAllAsRead" class="text-sm text-blue-500">Mark all as read</button>
            @endif
        </div>
        <div class="max-h-64 overflow-y-auto">
            @forelse($notifications as $notification)
                <div class="p-2 border-b flex justify-between items-start">
                    <div>
                        <strong>Order #{{ $notification->data['order_id'] }}</strong> -
                        {{ $notification->data['product_name'] }}
                        - {{ ucfirst($notification->data['status']) }}
                        <br>
                        <small>{{ $notification->data['message'] }}</small>
                    </div>
                    @if(!$notification->read_at)
                        <button wire:click="markAsRead('{{ $notification->id }}')" class="text-blue-500 text-sm">Mark as read</button>
                    @endif
                </div>
            @empty
                <p class="p-2 text-gray-500">No notifications.</p>
            @endforelse
        </div>
    </div>
</div>
