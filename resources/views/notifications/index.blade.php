<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Notifications
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if(auth()->user()->notifications->count())
                    
                    <!-- Mark all as read button -->
                    <form method="POST" action="{{ route('notifications.read') }}" class="mb-4">
                        @csrf
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                            Mark all as read
                        </button>
                    </form>

                    @foreach(auth()->user()->notifications as $notification)
                        <div class="border-b py-2">
                            <p class="text-gray-700">
                                {{ $notification->data['message'] ?? 'Notification' }}
                            </p>
                            <span class="text-xs text-gray-400">
                                {{ $notification->created_at->diffForHumans() }}
                            </span>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-500">📭 No notifications</p>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
