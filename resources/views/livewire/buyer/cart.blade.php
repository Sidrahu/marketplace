<div class="max-w-6xl mx-auto py-10 px-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-bold text-gray-800">🛒 Your Shopping Cart</h2>
        <span class="text-gray-500 text-sm">{{ $cartItems->count() }} items</span>
    </div>

    @if($cartItems->count() > 0)
        <!-- Cart Items -->
        <div class="bg-white rounded-2xl shadow-md overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50">
                    <tr class="border-b text-gray-600 text-sm">
                        <th class="p-4">Product</th>
                        <th class="p-4 text-center">Quantity</th>
                        <th class="p-4">Price</th>
                        <th class="p-4">Total</th>
                        <th class="p-4">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($cartItems as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <!-- Product -->
                            <td class="p-4 flex items-center gap-4">
                                @if($item->product->images->first())
                                    <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}"
                                         class="w-16 h-16 object-cover rounded-lg border">
                                @else
                                    <div class="w-16 h-16 bg-gray-100 flex items-center justify-center text-gray-400 rounded-lg">
                                        📦
                                    </div>
                                @endif
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $item->product->name }}</p>
                                    <p class="text-sm text-gray-500 line-clamp-1">{{ $item->product->description }}</p>
                                </div>
                            </td>

                            <!-- Quantity Controls -->
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button wire:click="decreaseQuantity({{ $item->id }})"
                                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-2 py-1 rounded-lg disabled:opacity-50"
                                            @if($item->quantity <= 1) disabled @endif>
                                        -
                                    </button>
                                    <span class="px-3 font-medium text-gray-800">{{ $item->quantity }}</span>
                                    <button wire:click="increaseQuantity({{ $item->id }})"
                                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-2 py-1 rounded-lg">
                                        +
                                    </button>
                                </div>
                            </td>

                            <!-- Price -->
                            <td class="p-4 text-gray-700 font-medium">
                                ${{ number_format($item->product->price, 2) }}
                            </td>

                            <!-- Total -->
                            <td class="p-4 text-gray-900 font-bold">
                                ${{ number_format($item->product->price * $item->quantity, 2) }}
                            </td>

                            <!-- Remove -->
                            <td class="p-4">
                                <button wire:click="removeItem({{ $item->id }})"
                                        class="text-red-500 hover:text-red-700 font-medium">
                                     Remove
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Summary Section -->
        <div class="mt-8 flex flex-col items-end gap-4">
            <div class="text-xl font-bold text-gray-800">
                Total: ${{ number_format($cartItems->sum(fn($item) => $item->product->price * $item->quantity), 2) }}
            </div>
            <button wire:click="checkout"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg transition">
                 Proceed to Checkout
            </button>
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-20 bg-white rounded-2xl shadow">
            
            <h3 class="text-lg font-semibold text-gray-700">Your cart is empty</h3>
            <p class="text-gray-500 mt-2">Looks like you haven’t added anything yet.</p>
            <a href="{{ route('buyer.dashboard') }}"
               class="mt-6 inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl shadow transition">
                🛍️ Browse Products
            </a>
        </div>
    @endif

    @if(session()->has('success'))
        <div class="mt-6 p-4 bg-green-100 border border-green-200 text-green-800 rounded-lg shadow-sm">
            ✅ {{ session('success') }}
        </div>
    @endif
</div>
