<div class="max-w-3xl mx-auto mt-10 bg-white p-8 rounded-2xl shadow-2xl">

    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">➕ Create Product</h2>

    <form wire:submit.prevent="save" class="space-y-6">

        {{-- Select Shop --}}
        <div>
            <label class="block font-semibold mb-2">Select Shop</label>
            <select wire:model="shopId" 
                    class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                <option value="">-- Choose a Shop --</option>
                @foreach($shops as $shop)
                    <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                @endforeach
            </select>
            @error('shopId') 
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
            @enderror

            {{-- Shop logo preview --}}
            @if($selectedShop)
                <div class="mt-3 flex items-center space-x-3 p-3 border rounded-lg bg-gray-50 shadow-sm">
                    <img src="{{ asset('storage/'.$selectedShop->logo) }}" 
                         alt="Shop Logo" 
                         class="w-14 h-14 rounded-full border object-cover">
                    <span class="font-semibold text-gray-800 text-lg">{{ $selectedShop->name }}</span>
                </div>
            @endif
        </div>

        {{-- Product Name --}}
        <div>
            <label class="block font-semibold mb-2">Product Name</label>
            <input type="text" wire:model.defer="name" 
                   class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
            @error('name') 
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        {{-- Description --}}
        <div>
            <label class="block font-semibold mb-2">Description</label>
            <textarea wire:model.defer="description" 
                      class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                      rows="4"></textarea>
            @error('description') 
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        {{-- Price & Quantity --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold mb-2">Price</label>
                <input type="number" wire:model.defer="price" 
                       class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                @error('price') 
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block font-semibold mb-2">Quantity</label>
                <input type="number" wire:model.defer="quantity" 
                       class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                @error('quantity') 
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Images --}}
        <div>
            <label class="block font-semibold mb-2">Product Images</label>
            <input type="file" wire:model="images" multiple 
                   class="w-full border border-gray-300 p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
            @error('images.*') 
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
            @enderror

            {{-- Image Preview --}}
            <div class="mt-4 flex flex-wrap gap-3">
                @foreach($images as $img)
                    <img src="{{ $img->temporaryUrl() }}" 
                         class="w-24 h-24 rounded-lg object-cover border shadow-sm">
                @endforeach
            </div>
        </div>

        {{-- Submit --}}
        <button type="submit" 
                class="w-full px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-all shadow-lg">
            Create Product
        </button>
    </form>
</div>
