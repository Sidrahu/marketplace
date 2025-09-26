<div class="max-w-6xl mx-auto py-10">
    <h2 class="text-2xl font-bold mb-6">📦 Orders List</h2>

    @if($orders->isEmpty())
        <p class="text-gray-500">No orders found.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 shadow-md rounded-lg">
                <thead>
                    <tr class="bg-gray-100 text-left text-gray-600 uppercase text-sm">
                        <th class="py-3 px-4 border-b"># Order ID</th>
                        <th class="py-3 px-4 border-b">Buyer</th>
                        <th class="py-3 px-4 border-b">Vendor</th>
                        <th class="py-3 px-4 border-b">Product</th>
                        <th class="py-3 px-4 border-b">Quantity</th>
                        <th class="py-3 px-4 border-b">Total Price</th>
                        <th class="py-3 px-4 border-b">Status</th>
                        {{-- <th class="py-3 px-4 border-b">Invoice ID</th> --}}
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach($orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4 border-b">{{ $order->id }}</td>
                            <td class="py-3 px-4 border-b">{{ $order->buyer->name ?? 'N/A' }}</td>
                            <td class="py-3 px-4 border-b">{{ $order->vendor->name ?? 'N/A' }}</td>
                            <td class="py-3 px-4 border-b">{{ $order->product->name ?? 'N/A' }}</td>
                            <td class="py-3 px-4 border-b">{{ $order->quantity }}</td>
                            <td class="py-3 px-4 border-b">${{ number_format($order->total_price, 2) }}</td>
                            <td class="py-3 px-4 border-b">
                                <span class="px-2 py-1 rounded text-white 
                                    {{ $order->status == 'pending' ? 'bg-yellow-500' : 
                                       ($order->status == 'completed' ? 'bg-green-500' : 'bg-red-500') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            {{-- <td class="py-3 px-4 border-b">
                               
                         {{ $order->invoice->invoice_number ?? 'N/A' }}
 

                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
