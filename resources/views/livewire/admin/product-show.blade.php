<div class="max-w-7xl mx-auto py-10">
    <h2 class="text-2xl font-bold mb-6">📦 Products Management</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Product</th>
                    <th class="px-4 py-2">Shop</th>
                    <th class="px-4 py-2">Price</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $product->id }}</td>
                        <td class="px-4 py-2">{{ $product->name }}</td>
                        <td class="px-4 py-2">{{ $product->shop->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2">${{ number_format($product->price, 2) }}</td>
                        <td class="px-4 py-2">
                            @if ($product->status === 'approved')
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">Approved</span>
                            @elseif ($product->status === 'rejected')
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">Rejected</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs">Pending</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 space-x-2">
                            <button wire:click="approve({{ $product->id }})"
                                class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs">Approve</button>
                            <button wire:click="reject({{ $product->id }})"
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">Reject</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-2 text-center text-gray-500">
                            No products found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
