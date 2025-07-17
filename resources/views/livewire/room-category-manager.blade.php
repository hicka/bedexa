<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    {{-- Form Section --}}
    <x-card>
        <x-slot name="header">
            {{ $roomCategoryId ? 'Update Category' : 'New Room Category' }}
        </x-slot>

        <x-slot name="body">
            <form wire:submit.prevent="save" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input label="Name" wire:model.defer="name" />
                <x-input label="Default Rate (MVR)" wire:model.defer="default_rate" type="number" />

                <div class="md:col-span-2">
                    <x-textarea label="Description" wire:model.defer="description" />
                </div>

                <div class="col-span-full">
                    <x-button type="submit" variant="primary">
                        {{ $roomCategoryId ? 'Update' : 'Create' }}
                    </x-button>
                    @if ($roomCategoryId)
                        <x-button variant="ghost" wire:click="resetForm" class="ml-2">
                            Cancel
                        </x-button>
                    @endif
                </div>
            </form>
        </x-slot>
    </x-card>

    {{-- Table Section --}}
    <x-card>
        <x-slot name="header"> Existing Categories </x-slot>

        <x-slot name="body">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                    <tr class="border-b text-left text-gray-700 dark:text-gray-300">
                        <th class="py-2">Name</th>
                        <th class="py-2">Rate</th>
                        <th class="py-2">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($categories as $cat)
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="py-2">{{ $cat->name }}</td>
                            <td class="py-2">MVR {{ number_format($cat->default_rate, 2) }}</td>
                            <td class="py-2 text-right space-x-2">
                                <x-button size="sm" wire:click="edit({{ $cat->id }})">Edit</x-button>
                                <x-button size="sm" variant="danger" wire:click="delete({{ $cat->id }})">Delete</x-button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-4 text-center text-gray-500">No categories found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </x-slot>
    </x-card>
</div>
