<div class="max-w-7xl mx-auto py-10 px-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-bold text-gray-800">📦 My Subscriptions</h2>
        <span class="text-gray-500 text-sm">{{ $subscriptions->count() }} active</span>
    </div>

    <!-- Success Alert -->
    @if(session()->has('success'))
        <div class="mb-6 p-4 rounded-lg bg-green-100 border border-green-200 text-green-800 flex items-center gap-2">
            ✅ {{ session('success') }}
        </div>
    @endif

    <!-- Empty State -->
    @if($subscriptions->isEmpty())
        <div class="text-center py-20 bg-white rounded-2xl shadow">
            
            <h3 class="text-xl font-semibold text-gray-800">You have no subscriptions</h3>
            <p class="text-gray-500 mt-2">Subscribe to a product to see it listed here.</p>
            <a href="{{ route('buyer.product.list') }}"
               class="mt-6 inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl shadow transition">
                Browse Products
            </a>
        </div>
    @else
        <!-- Subscription Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($subscriptions as $sub)
                <div class="bg-white rounded-2xl shadow hover:shadow-lg transition p-5 flex flex-col">
                    
                    <!-- Product Info -->
                    <div class="flex items-center gap-4">
                        @if($sub->product && $sub->product->images && $sub->product->images->count())
                            <img src="{{ asset('storage/' . $sub->product->images[0]->image_path) }}"
                                 alt="{{ $sub->product->name }}"
                                 class="w-20 h-20 rounded-lg object-cover border">
                        @else
                            <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 text-sm">
                                No Image
                            </div>
                        @endif
                        <div>
                            <h3 class="font-bold text-gray-900 text-lg">
                                {{ $sub->product ? $sub->product->name : 'N/A' }}
                            </h3>
                            @if($sub->product && $sub->product->shop)
                                <p class="text-sm text-gray-500">From: {{ $sub->product->shop->name }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Subscription Details -->
                    <div class="mt-4 text-sm text-gray-600 flex-1">
                        <p>📅 <span class="font-medium">Subscribed:</span> {{ \Carbon\Carbon::parse($sub->subscribed_at)->format('d M, Y') }}</p>
                        <p>⏳ <span class="font-medium">Next Billing:</span> {{ \Carbon\Carbon::parse($sub->next_billing_date)->format('d M, Y') }}</p>
                        <p>🔢 <span class="font-medium">Quantity:</span> {{ $sub->product ? $sub->product->quantity : 'N/A' }}</p>
                    </div>

                    <!-- Actions -->
                    <div class="mt-6">
                        <button wire:click="unsubscribe({{ $sub->product_id }})"
                                class="w-full bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-xl shadow transition">
                            Unsubscribe
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
