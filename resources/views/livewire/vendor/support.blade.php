<div class="max-w-5xl mx-auto py-12 px-6">

    {{-- 🔹 Header --}}
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fas fa-headset text-blue-600"></i> Support Tickets
        </h2>
    </div>

    {{-- 🔹 Success Message --}}
    @if(session()->has('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-6 shadow">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    {{-- 🔹 Submit Ticket Form --}}
    <form wire:submit.prevent="submitTicket" class="space-y-5 mb-8 bg-white shadow rounded-2xl p-6">
        <h3 class="text-xl font-semibold text-gray-800 mb-4"><i class="fas fa-plus-circle text-blue-500"></i> Submit a Ticket</h3>

        <div>
            <label class="block font-medium mb-1">Subject</label>
            <input type="text" wire:model.defer="subject" 
                   class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
            @error('subject') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-medium mb-1">Message</label>
            <textarea wire:model.defer="message" 
                      class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"></textarea>
            @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" 
                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
            <i class="fas fa-paper-plane"></i> Submit Ticket
        </button>
    </form>

    {{-- 🔹 Tickets Table --}}
    <div class="bg-white shadow rounded-2xl overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50 sticky top-0">
                <tr>
                    <th class="px-4 py-3 text-left text-gray-700 font-semibold text-sm">ID</th>
                    <th class="px-4 py-3 text-left text-gray-700 font-semibold text-sm">Subject</th>
                    <th class="px-4 py-3 text-left text-gray-700 font-semibold text-sm">Message</th>
                    <th class="px-4 py-3 text-left text-gray-700 font-semibold text-sm">Status</th>
                    <th class="px-4 py-3 text-left text-gray-700 font-semibold text-sm">Created At</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($tickets as $ticket)
                    @php
                        $statusColor = match($ticket->status) {
                            'open' => 'bg-yellow-100 text-yellow-800',
                            'closed' => 'bg-green-100 text-green-800',
                            'pending' => 'bg-blue-100 text-blue-800',
                            default => 'bg-gray-100 text-gray-800',
                        };
                    @endphp
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $ticket->id }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $ticket->subject }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $ticket->message }}</td>
                        <td class="px-4 py-3">
                            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $statusColor }}">
                                {{ ucfirst($ticket->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-700">{{ $ticket->created_at->format('d M, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-gray-500">No tickets found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
