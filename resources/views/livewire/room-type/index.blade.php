<div class="space-y-4">
    <x-page-heading title="Room Types" subtitle="Manage all available room types">
        <x-button href="{{ route('room-types.create') }}" variant="primary">
            + New Room Type
        </x-button>
    </x-page-heading>

    <div class="bg-white dark:bg-slate-900 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700">
        <x-input label="Search" wire:model.live.debounce.300ms="search" placeholder="Search by name..." class="mb-6" />

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left border-separate border-spacing-y-2">
                <thead>
                <tr class="text-gray-600 dark:text-gray-300 uppercase text-xs tracking-wider">
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Base Price</th>
                    <th class="px-4 py-2">Description</th>
                    <th class="px-4 py-2 text-right">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($roomTypes as $type)
                    <tr class="bg-gray-50 dark:bg-slate-800 hover:bg-gray-100 dark:hover:bg-slate-700 transition-all rounded-xl">
                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $type->name }}</td>
                        <td class="px-4 py-3 text-gray-700 dark:text-gray-300">${{ number_format($type->base_price, 2) }}</td>
                        <td class="px-4 py-3 text-gray-500 dark:text-gray-400">{{ $type->description }}</td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <x-button size="sm" href="{{ route('room-types.edit', $type->id) }}">Edit</x-button>
                            <x-button size="sm" variant="danger" wire:click="delete({{ $type->id }})">Delete</x-button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-gray-500 dark:text-gray-400 py-6">
                            No room types found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $roomTypes->links() }}
        </div>
    </div>
</div>
