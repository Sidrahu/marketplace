<div class="p-6 max-w-6xl mx-auto bg-white rounded-2xl shadow-2xl">

    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">📦 Your Orders</h2>

    @if(session()->has('message'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4 shadow-sm">
            {{ session('message') }}
        </div>
    @endif

    @if($orders->isEmpty())
        <p class="text-gray-500 text-center py-4">No orders found.</p>
    @else
        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse">
                <thead class="bg-gray-50 sticky top-0">
                    <tr>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold text-sm">Order ID</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold text-sm">Buyer</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold text-sm">Product</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold text-sm">Quantity</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold text-sm">Total Price</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold text-sm">Status</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold text-sm">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($orders as $order)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-gray-800 font-medium">{{ $order->id }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ $order->buyer->name }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ $order->product->name }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ $order->quantity }}</td>
                            <td class="px-4 py-3 text-blue-600 font-medium">${{ number_format($order->total_price, 2) }}</td>
                            <td class="px-4 py-3">
                                @if($order->status == 'pending')
                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-semibold">Pending</span>
                                @elseif($order->status == 'completed')
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold">Completed</span>
                                @else
                                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-semibold">Cancelled</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <select wire:change="updateStatus({{ $order->id }}, $event.target.value)" 
                                        class="border border-gray-300 rounded-lg px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                                    <option value="pending" @if($order->status == 'pending') selected @endif>Pending</option>
                                    <option value="completed" @if($order->status == 'completed') selected @endif>Completed</option>
                                    <option value="cancelled" @if($order->status == 'cancelled') selected @endif>Cancelled</option>
                                </select>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
