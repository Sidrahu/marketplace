<div class="max-w-7xl mx-auto p-6 space-y-10">
    <!-- Title -->
    <div class="flex items-center justify-between">
        <h2 class="text-3xl font-extrabold flex items-center gap-2 text-gray-800">
            📊 Admin Dashboard
        </h2>
        <span class="text-sm text-gray-500">Last updated: {{ now()->format('d M, Y H:i') }}</span>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Buyers -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-700 shadow-xl rounded-2xl p-6 text-center text-white transform hover:-translate-y-1 hover:shadow-2xl transition-all duration-300">
            <h3 class="text-sm uppercase tracking-wide opacity-90">Total Buyers</h3>
            <p class="text-5xl font-extrabold mt-2">{{ $totalBuyers }}</p>
        </div>
        <!-- Vendors -->
        <div class="bg-gradient-to-r from-green-500 to-green-700 shadow-xl rounded-2xl p-6 text-center text-white transform hover:-translate-y-1 hover:shadow-2xl transition-all duration-300">
            <h3 class="text-sm uppercase tracking-wide opacity-90">Total Vendors</h3>
            <p class="text-5xl font-extrabold mt-2">{{ $totalVendors }}</p>
        </div>
        <!-- Orders -->
        <div class="bg-gradient-to-r from-purple-500 to-purple-700 shadow-xl rounded-2xl p-6 text-center text-white transform hover:-translate-y-1 hover:shadow-2xl transition-all duration-300">
            <h3 class="text-sm uppercase tracking-wide opacity-90">Total Orders</h3>
            <p class="text-5xl font-extrabold mt-2">{{ $totalOrders }}</p>
        </div>
    </div>

    <!-- Orders by Status -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-yellow-50 border border-yellow-200 shadow rounded-xl p-6 text-center hover:shadow-lg transition">
            <h3 class="text-gray-700 font-semibold">Pending Orders</h3>
            <p class="text-4xl font-extrabold text-yellow-600 mt-2">{{ $pendingOrders }}</p>
        </div>
        <div class="bg-green-50 border border-green-200 shadow rounded-xl p-6 text-center hover:shadow-lg transition">
            <h3 class="text-gray-700 font-semibold">Completed Orders</h3>
            <p class="text-4xl font-extrabold text-green-600 mt-2">{{ $completedOrders }}</p>
        </div>
        <div class="bg-red-50 border border-red-200 shadow rounded-xl p-6 text-center hover:shadow-lg transition">
            <h3 class="text-gray-700 font-semibold">Cancelled Orders</h3>
            <p class="text-4xl font-extrabold text-red-600 mt-2">{{ $cancelledOrders }}</p>
        </div>
    </div>

    <!-- Latest Orders Table -->
    <div class="bg-white shadow-xl rounded-2xl p-6">
        <h3 class="text-xl font-bold mb-6 flex items-center gap-2 text-gray-800">
            📝 Latest Orders
        </h3>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                        <th class="p-3 text-left">#</th>
                        <th class="p-3 text-left">Buyer</th>
                        <th class="p-3 text-left">Vendor</th>
                        <th class="p-3 text-left">Product</th>
                        <th class="p-3 text-left">Total Price</th>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3 text-left">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse(\App\Models\Order::with(['buyer','vendor','product'])->latest()->take(5)->get() as $order)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-3">{{ $order->id }}</td>
                            <td class="p-3 font-medium">{{ $order->buyer->name ?? 'N/A' }}</td>
                            <td class="p-3 font-medium">{{ $order->vendor->name ?? 'N/A' }}</td>
                            <td class="p-3">{{ $order->product->name ?? 'N/A' }}</td>
                            <td class="p-3 font-semibold text-gray-800">${{ number_format($order->total_price, 2) }}</td>
                            <td class="p-3">
                                <span class="px-3 py-1 text-xs font-bold rounded-full 
                                    @if($order->status == 'pending') bg-yellow-100 text-yellow-700
                                    @elseif($order->status == 'completed') bg-green-100 text-green-700
                                    @else bg-red-100 text-red-700 @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="p-3 text-gray-500">{{ $order->created_at->format('d M, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-6 text-center text-gray-500">No orders yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
