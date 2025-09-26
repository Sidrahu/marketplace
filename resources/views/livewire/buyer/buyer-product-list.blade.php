<div class="max-w-7xl mx-auto p-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-800">🛍️ Shops & Products</h1>
        <span class="text-gray-500 text-sm">{{ $products->count() }} total products</span>
    </div>

    @php
        // Group products by shop_id
        $groupedProducts = $products->groupBy('shop_id');
    @endphp

    @forelse($groupedProducts as $shopId => $shopProducts)
        <div class="mb-12">
            <!-- Shop Header -->
            <div class="flex items-center justify-between mb-6 border-b pb-3">
                <h2 class="text-2xl font-bold text-gray-800">
                    🏪 {{ $shopProducts->first()->shop->name ?? 'Unknown Shop' }}
                </h2>
                <span class="text-gray-500 text-sm">
                    {{ $shopProducts->count() }} Products
                </span>
            </div>

            <!-- Products Grid (Inside Shop) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($shopProducts as $product)
                    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition border border-gray-100 overflow-hidden flex flex-col">
                        
                        <!-- Product Image -->
                        <div class="relative w-full h-56">
                            @if($product->images->first())
                                <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400 text-sm">
                                    No Image
                                </div>
                            @endif
                        </div>

                        <!-- Product Details -->
                        <div class="flex-1 p-5 flex flex-col justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-1">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $product->description }}</p>

                                <!-- Subscription Info -->
                                @if($buyer->subscriptions->contains($product->id))
                                    <p class="text-xs font-medium text-green-600">
                                        ✅ You are subscribed to this product
                                    </p>
                                @else
                                    <p class="text-xs font-medium text-gray-400">
                                        ⏳ Not Subscribed
                                    </p>
                                @endif
                            </div>

                            <!-- Subscribe/Unsubscribe Button -->
                            <div class="mt-5">
                                @if($buyer->subscriptions->contains($product->id))
                                    <button wire:click="unsubscribe({{ $product->id }})"
                                            class="w-full bg-red-500 text-white px-4 py-2 rounded-xl hover:bg-red-600 transition">
                                        Unsubscribe
                                    </button>
                                @else
                                    <button wire:click="subscribe({{ $product->id }})"
                                            class="w-full bg-blue-500 text-white px-4 py-2 rounded-xl hover:bg-blue-600 transition">
                                        Subscribe
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <!-- Empty State -->
        <div class="text-center py-20">
            <p class="text-gray-500">No shops or products available at the moment.</p>
        </div>
    @endforelse
</div>
