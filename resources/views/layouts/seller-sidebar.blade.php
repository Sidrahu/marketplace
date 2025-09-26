<div class="w-64 h-screen bg-gray-800 text-white flex flex-col">
    <div class="p-4 font-bold text-xl border-b border-gray-700">
        Seller Panel
    </div>
    <nav class="flex-grow p-4 space-y-2">
        <a href="{{ route('vendor.dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-700">Dashboard</a>
        <a href="{{ route('vendor.products.index') }}" class="block px-3 py-2 rounded hover:bg-gray-700">Products</a>
        <a href="{{ route('vendor.orders.index') }}" class="block px-3 py-2 rounded hover:bg-gray-700">Orders</a> 
        <a href="{{ route('notifications.read.get') }}" class="block px-3 py-2 rounded hover:bg-gray-700">Notifications</a>
 
        <a href="{{ route('vendor.shop.settings') }}" class="block px-3 py-2 rounded hover:bg-gray-700">Shop Settings</a>
    
        <a href="{{ route('vendor.sales.reports') }}" class="block px-3 py-2 rounded hover:bg-gray-700">
    Sales & Reports
</a>

      

        <a href="{{ route('vendor.support') }}" class="block px-3 py-2 rounded hover:bg-gray-700">Support</a>
        <a href="{{ route('vendor.profile') }}" class="block px-3 py-2 rounded hover:bg-gray-700">Profile</a> 
        <a href="#" class="block px-3 py-2 rounded hover:bg-gray-700">Logout</a>
    </nav>
</div>
