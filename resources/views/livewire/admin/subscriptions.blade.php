<div class="max-w-4xl mx-auto py-10">
    <h2 class="text-2xl font-bold mb-6">📌 My Subscriptions</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="createSubscription" class="mb-6 space-y-4">
        <input type="text" wire:model="plan_name" placeholder="Plan Name" class="w-full border p-2 rounded">
        <input type="number" wire:model="price" placeholder="Price" class="w-full border p-2 rounded">
        <input type="date" wire:model="start_date" class="w-full border p-2 rounded">
        <input type="date" wire:model="end_date" class="w-full border p-2 rounded">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Create</button>
    </form>

    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="p-2">Plan</th>
                <th class="p-2">Price</th>
                <th class="p-2">Start</th>
                <th class="p-2">End</th>
                <th class="p-2">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($subscriptions as $sub)
                <tr class="border-b">
                    <td class="p-2">{{ $sub->plan_name }}</td>
                    <td class="p-2">${{ $sub->price }}</td>
                    <td class="p-2">{{ $sub->start_date }}</td>
                    <td class="p-2">{{ $sub->end_date }}</td>
                    <td class="p-2">{{ ucfirst($sub->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-gray-500 text-center p-4">No subscriptions yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
