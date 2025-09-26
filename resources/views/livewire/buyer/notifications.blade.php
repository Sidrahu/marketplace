<div>
    <h2>Notifications</h2>
    @foreach($notifications as $notification)
        <div class="p-2 border rounded mb-1 bg-blue-100">
            {{ $notification['data']['message'] }}
            <button wire:click="markAsRead('{{ $notification['id'] }}')" class="ml-4 text-sm text-gray-600 underline">Mark as read</button>
        </div>
    @endforeach

    @if(empty($notifications))
        <p>No new notifications.</p>
    @endif
</div>

<script>
    window.addEventListener('notify', event => {
        {{-- alert(event.detail.message); --}}
    });
</script>
