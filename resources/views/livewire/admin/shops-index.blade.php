<div class="max-w-7xl mx-auto py-8">
    <h2 class="text-2xl font-bold mb-6">🏪 Vendors / Shops Management</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <div class="flex items-center gap-4 mb-4">
        <input type="text" wire:model="search" placeholder="Search shops or vendors..."
               class="border rounded px-3 py-2 w-1/3">

        <select wire:model="statusFilter" class="border rounded px-3 py-2">
            <option value="">All Status</option>
            <option value="approved">Approved</option>
            <option value="blocked">Blocked</option>
            <option value="pending">Pending</option>
        </select>
    </div>

    <table class="w-full bg-white border rounded-lg shadow">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-3 text-left">#</th>
                <th class="p-3 text-left">Shop Name</th>
                <th class="p-3 text-left">Vendor</th>
                <th class="p-3 text-left">Status</th>
                <th class="p-3 text-left">Created At</th>
                <th class="p-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($shops as $shop)
                <tr class="border-b">
                    <td class="p-3">{{ $shop->id }}</td>
                    <td class="p-3">{{ $shop->name }}</td>
                    <td class="p-3">{{ $shop->user->name ?? 'N/A' }}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded text-white
                            @if($shop->status == 'approved') bg-green-500
                            @elseif($shop->status == 'blocked') bg-red-500
                            @else bg-yellow-500 @endif">
                            {{ ucfirst($shop->status) }}
                        </span>
                    </td>
                    <td class="p-3">{{ $shop->created_at->format('d M, Y') }}</td>
                    <td class="p-3 flex gap-2">
                        @if($shop->status != 'approved')
                            <button wire:click="approveShop({{ $shop->id }})"
                                class="px-3 py-1 bg-green-500 text-white rounded">Approve</button>
                        @endif

                        @if($shop->status != 'blocked')
                            <button wire:click="blockShop({{ $shop->id }})"
                                class="px-3 py-1 bg-red-500 text-white rounded">Block</button>
                        @endif

                        <button wire:click="deleteShop({{ $shop->id }})"
                            class="px-3 py-1 bg-gray-600 text-white rounded">Delete</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="p-3 text-center text-gray-500">
                        No shops found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $shops->links() }}
    </div>
</div>
