<div class="max-w-6xl mx-auto py-8">
    <h2 class="text-2xl font-bold mb-6">👥 Users Management</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <button wire:click="create"
        class="bg-blue-600 text-white px-4 py-2 rounded mb-4 hover:bg-blue-700">+ Add User</button>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="w-full border-collapse">
            <thead class="bg-gray-100 text-gray-700 uppercase text-sm">
                <tr>
                    <th class="border px-4 py-2 text-left">#</th>
                    <th class="border px-4 py-2 text-left">Name</th>
                    <th class="border px-4 py-2 text-left">Email</th>
                    <th class="border px-4 py-2 text-left">Role</th>
                    <th class="border px-4 py-2 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $user->id }}</td>
                        <td class="border px-4 py-2">{{ $user->name }}</td>
                        <td class="border px-4 py-2">{{ $user->email }}</td>
                        <td class="border px-4 py-2">
                            <span class="px-2 py-1 rounded text-white text-xs
                                @if($user->roles->pluck('name')->first() == 'admin') bg-red-600
                                @elseif($user->roles->pluck('name')->first() == 'vendor') bg-purple-600
                                @elseif($user->roles->pluck('name')->first() == 'buyer') bg-blue-600
                                @else bg-gray-400 @endif">
                                {{ ucfirst($user->roles->pluck('name')->first() ?? 'No Role') }}
                            </span>
                        </td>
                        <td class="border px-4 py-2 text-center">
                            <button wire:click="edit({{ $user->id }})"
                                class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">✏️ Edit</button>
                            <button wire:click="delete({{ $user->id }})"
                                class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">🗑️ Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>

    <!-- Modal -->
    @if ($isOpen)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
                <h2 class="text-xl font-bold mb-4">{{ $user_id ? '✏️ Edit User' : '➕ Add User' }}</h2>

                <form wire:submit.prevent="store">
                    <div class="mb-4">
                        <label class="block text-gray-700">Name</label>
                        <input type="text" wire:model="name"
                            class="w-full px-4 py-2 border rounded mt-1">
                        @error('name') <span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Email</label>
                        <input type="email" wire:model="email"
                            class="w-full px-4 py-2 border rounded mt-1">
                        @error('email') <span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Password</label>
                        <input type="password" wire:model="password"
                            class="w-full px-4 py-2 border rounded mt-1">
                        @error('password') <span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Role</label>
                        <select wire:model="role" class="w-full px-4 py-2 border rounded mt-1">
                            <option value="">-- Select Role --</option>
                            @foreach($roles as $r)
                                <option value="{{ $r->name }}">{{ ucfirst($r->name) }}</option>
                            @endforeach
                        </select>
                        @error('role') <span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="button" wire:click="closeModal"
                            class="bg-gray-400 text-white px-4 py-2 rounded mr-2">Cancel</button>
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded">{{ $user_id ? 'Update' : 'Save' }}</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
