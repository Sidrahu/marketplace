<div class="max-w-6xl mx-auto py-12 px-6">

    {{-- 🔹 Header --}}
    <h2 class="text-3xl font-bold text-gray-800 mb-8 flex items-center gap-2">📊 Sales & Reports</h2>

    {{-- 🔹 Total Sales Card --}}
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 flex items-center justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-700">Total Sales</h3>
            <p class="text-3xl font-bold text-gray-900 mt-2">${{ number_format($totalSales, 2) }}</p>
        </div>
        <div class="text-blue-500 text-6xl font-bold opacity-20">💰</div>
    </div>

    {{-- 🔹 Orders Table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-2xl shadow-lg divide-y divide-gray-200">
            <thead class="bg-gray-50 sticky top-0">
                <tr>
                    <th class="px-4 py-3 text-left text-gray-700 font-semibold text-sm">Order ID</th>
                    <th class="px-4 py-3 text-left text-gray-700 font-semibold text-sm">Customer</th>
                    <th class="px-4 py-3 text-left text-gray-700 font-semibold text-sm">Product</th>
                    <th class="px-4 py-3 text-left text-gray-700 font-semibold text-sm">Image</th>
                    <th class="px-4 py-3 text-left text-gray-700 font-semibold text-sm">Quantity</th>
                    <th class="px-4 py-3 text-left text-gray-700 font-semibold text-sm">Total Price</th>
                    <th class="px-4 py-3 text-left text-gray-700 font-semibold text-sm">Status</th>
                    <th class="px-4 py-3 text-left text-gray-700 font-semibold text-sm">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($orders as $order)
                    @php
                        $product = $order->product;
                        $statusColor = match($order->status) {
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'completed' => 'bg-green-100 text-green-800',
                            'cancelled' => 'bg-red-100 text-red-800',
                            default => 'bg-gray-100 text-gray-800'
                        };
                    @endphp
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-gray-800 font-medium">{{ $order->id }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $order->buyer ? $order->buyer->name : 'N/A' }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $product ? $product->name : 'N/A' }}</td>
                        <td class="px-4 py-3">
                            @if($product && $product->images->count())
                                <div class="flex space-x-2">
                                    @foreach($product->images as $img)
                                        <img src="{{ asset('storage/' . $img->image_path) }}" 
                                             class="w-12 h-12 object-cover rounded-lg border shadow-sm" 
                                             alt="{{ $product->name }}">
                                    @endforeach
                                </div>
                            @else
                                <span class="text-gray-400">N/A</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-700">{{ $order->quantity }}</td>
                        <td class="px-4 py-3 text-gray-900 font-semibold">${{ number_format($order->total_price, 2) }}</td>
                        <td class="px-4 py-3">
                            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $statusColor }}">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td class="px-4 py-3 text-gray-700">{{ $order->created_at->format('d M, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-6 text-gray-500">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
