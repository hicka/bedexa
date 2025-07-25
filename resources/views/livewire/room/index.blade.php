<div class="bg-white dark:bg-slate-900 p-4 rounded-xl shadow border border-gray-200 dark:border-slate-700">
    <div class="flex justify-between items-center mb-4">
        <x-page-heading title="Rooms" class="mb-0" />
        <x-button href="{{ route('rooms.create') }}" variant="primary">+ New Room</x-button>
    </div>

    <x-input label="Search" wire:model.live.debounce.300ms="search" placeholder="Search by room number..." class="mb-4" />

    <table class="min-w-full text-sm">
        <thead>
        <tr class="border-b text-left">
            <th class="py-2">Room Number</th>
            <th class="py-2">Type</th>
            <th class="text-left py-2">Status</th>
            <th class="text-right py-2">Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($rooms as $room)
            <tr class="border-b">
                <td class="py-2">{{ $room->room_number }}</td>
                <td class="py-2">{{ $room->type?->name }}</td>
                <td class="py-2">
                    @switch($room->status)
                        @case('available')
                            <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                Available
            </span>
                            @break

                        @case('occupied')
                            <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                Occupied
            </span>
                            @break

                        @case('maintenance')
                            <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                Maintenance
            </span>
                            @break

                        @default
                            <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-slate-700 dark:text-gray-300">
                Unknown
            </span>
                    @endswitch
                </td>
                <td class="py-2 text-right space-x-2">
                    <x-button size="sm" href="{{ route('rooms.edit', $room->id) }}">Edit</x-button>
                    <x-button size="sm" variant="danger" wire:click="delete({{ $room->id }})">Delete</x-button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="py-4 text-center text-gray-500">No rooms found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $rooms->links() }}
    </div>
</div>
