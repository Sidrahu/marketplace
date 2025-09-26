<div class="max-w-6xl mx-auto p-8 bg-white shadow-xl rounded-2xl border border-gray-100 mt-10">
    
    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-extrabold text-gray-800">📦 My Orders</h1>
        <span class="text-sm text-gray-500">Total Orders: {{ $orders->count() }}</span>
    </div>

    {{-- Orders List --}}
    @forelse ($orders as $order)
        <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 mb-6 shadow-sm hover:shadow-md transition">
            
            {{-- Order Header --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Order #{{ $order->id }}</h2>
                <span class="text-sm text-gray-500">Placed on {{ $order->created_at->format('M d, Y') }}</span>
            </div>

            {{-- Shop Info --}}
            <div class="mb-4">
                <p class="text-sm text-gray-500">
                    Shop: <span class="font-medium">{{ $order->product->shop->name ?? 'N/A' }}</span>
                </p>
            </div>

            {{-- Order Body --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                
                {{-- Product Thumbnail + Info --}}
                <div class="flex items-center gap-4">
                    <img src="{{ $order->product->image_url }}" 
                         alt="{{ $order->product->name }}" 
                         class="w-20 h-20 rounded-lg object-cover border">
                    
                    <div>
                        <p class="text-gray-800 font-medium">{{ $order->product->name }}</p>
                        <p class="text-sm text-gray-500">Sold by: {{ $order->vendor->name ?? 'Vendor' }}</p>
                        <p class="text-sm text-gray-600 mt-1">Amount: 
                            <span class="font-semibold text-green-600">
                                ${{ number_format($order->total_amount ?? 0, 2) }}
                            </span>
                        </p>
                    </div>
                </div>

                {{-- Status Badge --}}
                <div>
                    @if($order->status == 'completed')
                        <span class="px-4 py-2 text-sm rounded-full bg-green-100 text-green-700 font-medium flex items-center gap-1">
                            ✅ Completed
                        </span>
                    @elseif($order->status == 'cancelled')
                        <span class="px-4 py-2 text-sm rounded-full bg-red-100 text-red-700 font-medium flex items-center gap-1">
                            ❌ Cancelled
                        </span>
                    @else
                        <span class="px-4 py-2 text-sm rounded-full bg-yellow-100 text-yellow-700 font-medium flex items-center gap-1">
                            ⏳ Pending
                        </span>
                    @endif
                </div>
            </div>

            {{-- Actions --}}
            <div class="mt-6 flex flex-wrap gap-3">
                {{-- <a href="{{ route('buyer.orders.index', $order->id) }}" 
                   class="px-5 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow hover:bg-blue-700 transition">
                    🔍 View Details
                </a> --}}
                <a href="{{ route('invoice.download', $order->id) }}" 
                   class="px-5 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg shadow hover:bg-gray-200 transition">
                    📄 Download Invoice
                </a>
            </div>
        </div>
    @empty
        {{-- Empty State --}}
        <div class="text-center py-16">
            <svg class="mx-auto w-20 h-20 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M3 3h18v18H3V3z" />
            </svg>
            <p class="text-gray-500 text-lg font-medium">You have no orders yet.</p>
            <a href="/" 
               class="mt-4 inline-block px-6 py-3 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
               🛍️ Continue Shopping
            </a>
        </div>
    @endforelse
</div>
