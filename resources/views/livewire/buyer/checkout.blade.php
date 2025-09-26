<div class="max-w-3xl mx-auto mt-10 bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
            Checkout
        </h2>
        <span class="text-sm text-gray-500">
            Secure Payment with Stripe
        </span>
    </div>

    @if($cartItems && $cartItems->count() > 0)
        <!-- Cart Items -->
        <div class="space-y-6">
            @foreach ($cartItems as $item)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:shadow transition">
                    <div class="flex items-center gap-4">
                        @if($item->product->images && count($item->product->images) > 0)
                            <img src="{{ asset('storage/' . $item->product->images[0]->image_path) }}"
                                 class="w-14 h-14 rounded-lg object-cover shadow-sm">
                        @else
                            <div class="w-14 h-14 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400">
                                
                            </div>
                        @endif
                        <div>
                            <h4 class="font-semibold text-gray-800">{{ $item->product->name }}</h4>
                            <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                        </div>
                    </div>
                    <p class="font-bold text-gray-700">
                        ${{ number_format($item->product->price * $item->quantity, 2) }}
                    </p>
                </div>
            @endforeach
        </div>

        <!-- Order Summary -->
        <div class="mt-8 border-t pt-6">
            <div class="flex justify-between mb-2 text-gray-600">
                <span>Subtotal</span>
                <span>${{ number_format($cartItems->sum(fn($item) => $item->product->price * $item->quantity), 2) }}</span>
            </div>
            <div class="flex justify-between mb-2 text-gray-600">
                <span>Tax (10%)</span>
                <span>${{ number_format($cartItems->sum(fn($item) => $item->product->price * $item->quantity) * 0.10, 2) }}</span>
            </div>
            <div class="flex justify-between font-bold text-lg text-gray-800">
                <span>Total</span>
                <span>
                    ${{ number_format($cartItems->sum(fn($item) => $item->product->price * $item->quantity) * 1.10, 2) }}
                </span>
            </div>
        </div>

        <!-- Checkout Button -->
        <div class="mt-8">
            <button wire:click="processCheckout"
                wire:loading.attr="disabled"
                wire:target="processCheckout"
                class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:from-blue-700 hover:to-indigo-700 transition disabled:opacity-50">
                <span wire:loading.remove wire:target="processCheckout"> Pay with Stripe</span>
                <span wire:loading wire:target="processCheckout">Processing...</span>
            </button>
        </div>
    @else
        <div class="text-center py-16">
            <p class="text-gray-500 text-lg">🛒 Your cart is empty.</p>
        </div>
    @endif

    <!-- Flash Messages -->
    @if(session()->has('error'))
        <div class="mt-6 bg-red-50 text-red-700 p-4 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    @if(session()->has('success'))
        <div class="mt-6 bg-green-50 text-green-700 p-4 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Invoice Download -->
    @if(isset($recentInvoice) && $recentInvoice)
        <div class="mt-8 text-right">
            <button wire:click="downloadInvoice('{{ $recentInvoice->id }}')"
                class="bg-green-600 text-white px-5 py-2 rounded-xl hover:bg-green-700 shadow-md">
                 Download Invoice PDF
            </button>
        </div>
    @endif
</div>
