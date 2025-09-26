<div class="max-w-7xl mx-auto p-8">

    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Buyer Dashboard</h1>
        <div class="flex items-center gap-4">
            <button class="relative p-2 rounded-full hover:bg-gray-100">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M15 17h5l-1.405-1.405..." stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>
            <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" class="w-10 h-10 rounded-full border">
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
        <!-- Active Subscriptions -->
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <p class="text-sm text-gray-500">Active Subscriptions</p>
            <h2 class="text-2xl font-bold text-blue-600">{{ $subscriptions->count() }}</h2>
        </div>

        <!-- Next Billing -->
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <p class="text-sm text-gray-500">Next Billing</p>
            <h2 class="text-lg font-semibold text-gray-700">
                {{ $subscriptions->first()? \Carbon\Carbon::parse($subscriptions->first()->pivot->next_billing_date)->format('d M, Y') : '-' }}
            </h2>
        </div>

        <!-- Total Spent -->
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <p class="text-sm text-gray-500">Total Spent</p>
            <h2 class="text-2xl font-bold text-green-600">${{ number_format($totalSpent, 2) }}</h2>
        </div>

        <!-- Cart Items -->
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <p class="text-sm text-gray-500">Cart Items</p>
            <h2 class="text-2xl font-bold text-purple-600">{{ $cartCount ?? 0 }}</h2>
        </div>
    </div>

    <!-- Subscriptions Section -->
    <h2 class="text-2xl font-semibold mb-6 text-gray-800 flex items-center gap-2">
        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M3 7h18M3 12h18M3 17h18" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Your Subscriptions
    </h2>

    @forelse ($subscriptions as $subscription)
        <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition mb-6 overflow-hidden border border-gray-100">
            <div class="md:flex">
                @if ($subscription->images && count($subscription->images) > 0)
                    <div class="md:w-1/3">
                        <img src="{{ asset('storage/' . $subscription->images[0]->image_path) }}"
                             class="w-full h-full object-cover md:rounded-l-2xl">
                    </div>
                @endif
                <div class="p-6 md:w-2/3 flex flex-col justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 mb-2">{{ $subscription->name }}</h2>
                        <p class="text-gray-600 text-sm mb-4">{{ $subscription->description }}</p>
                        <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M8 7V3M16 7V3M4 11h16..." stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>Next Billing: 
                                <span class="font-medium text-gray-700">
                                    {{ \Carbon\Carbon::parse($subscription->pivot->next_billing_date)->format('d M, Y') }}
                                </span>
                            </span>
                        </div>
                    </div>
                    <div>
                        @livewire('buyer.add-to-cart', ['productId' => $subscription->id], key('subscription-'.$subscription->id))
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-20">
             
            <p class="text-gray-500">You don’t have any subscriptions yet.</p>
        </div>
    @endforelse
</div>
