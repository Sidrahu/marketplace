<div class="max-w-6xl mx-auto py-10">
    <h2 class="text-2xl font-bold mb-6">📑 Reports & Analytics</h2>

    <div class="flex space-x-4 mb-6">
        <div>
            <label for="month" class="block text-sm font-medium text-gray-700">Month</label>
            <select wire:model="month" id="month" class="border rounded px-3 py-2">
                @foreach(range(1,12) as $m)
                    <option value="{{ $m }}">{{ date("F", mktime(0,0,0,$m,1)) }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="year" class="block text-sm font-medium text-gray-700">Year</label>
            <select wire:model="year" id="year" class="border rounded px-3 py-2">
                @foreach(range(date('Y'), date('Y')-5) as $y)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white shadow rounded p-4">
            <h3 class="text-lg font-semibold">📦 Total Orders</h3>
            <p class="text-2xl font-bold mt-2">{{ $totalOrders }}</p>
        </div>

        <div class="bg-white shadow rounded p-4">
            <h3 class="text-lg font-semibold">💰 Total Revenue</h3>
            <p class="text-2xl font-bold mt-2">${{ number_format($totalRevenue, 2) }}</p>
        </div>

        <div class="bg-white shadow rounded p-4">
            <h3 class="text-lg font-semibold">🔔 Active Subscriptions</h3>
            <p class="text-2xl font-bold mt-2">{{ $activeSubscriptions }}</p>
        </div>

        <div class="bg-white shadow rounded p-4">
            <h3 class="text-lg font-semibold">👥 New Users</h3>
            <p class="text-2xl font-bold mt-2">{{ $newUsers }}</p>
        </div>
    </div>
</div>
