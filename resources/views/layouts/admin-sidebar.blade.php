<!-- resources/views/layouts/admin-sidebar.blade.php -->

<aside class="w-64 h-screen bg-gray-900 text-white fixed">
    <div class="p-6">
        <h2 class="text-2xl font-bold">Admin Panel</h2>
    </div>
    <nav class="mt-6">
        <ul>
            <li class="mb-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 hover:bg-gray-700 rounded">
                    📊 <span class="ml-2">Dashboard</span>
                </a>
            </li>
            <li class="mb-2">
                <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-2 hover:bg-gray-700 rounded">
                    👥 <span class="ml-2">Users Management</span>
                </a>
            </li>
            <li class="mb-2">
                <a href="{{ route('admin.shops.index') }}" class="flex items-center px-4 py-2 hover:bg-gray-700 rounded">
                    🏪 <span class="ml-2">Vendors / Shops</span>
                </a>
            </li>
            <li class="mb-2">
                <a href="{{ route('admin.products.index') }}" class="flex items-center px-4 py-2 hover:bg-gray-700 rounded">
                    📦 <span class="ml-2">Products</span>
                </a>
            </li>
            <li class="mb-2">
                <a href="{{ route('admin.orders.invoices') }}" class="flex items-center px-4 py-2 hover:bg-gray-700 rounded">
                    🧾 <span class="ml-2">Orders</span>
                </a>
            </li>
          <li class="mb-2">
    <a href="{{ route('admin.subscriptions') }}" class="flex items-center px-4 py-2 hover:bg-gray-700 rounded">
        🔔 <span class="ml-2">Subscriptions</span>
    </a>
</li>

            <li class="mb-2">
                <a href="{{ route('admin.reports') }}" class="flex items-center px-4 py-2 hover:bg-gray-700 rounded">
                    📑 <span class="ml-2">Reports & Analytics</span>
                </a>
            </li>
            <li class="mb-2">
    <a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-2 hover:bg-gray-700 rounded">
        ⚙️ <span class="ml-2">Settings</span>
    </a>
</li>

        </ul>
    </nav>
</aside>

<!-- Content wrapper -->
<div class="ml-64 p-6">
    @yield('content')
</div>
