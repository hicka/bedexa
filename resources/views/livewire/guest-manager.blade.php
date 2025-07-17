
    <div class="flex flex-col gap-4">
        <x-card header="{{ $guestId ? 'Update Guest' : 'New Guest' }}">
            <form wire:submit.prevent="save" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input label="Full Name" wire:model.defer="full_name" />
                <x-input label="Email" wire:model.defer="email" />
                <x-input label="Phone" wire:model.defer="phone" />
                <x-input label="Nationality" wire:model.defer="nationality" />
                <x-input label="Passport Number" wire:model.defer="passport_number" />
                <x-textarea label="Address" wire:model.defer="address" class="md:col-span-2" />
                <x-textarea label="Notes" wire:model.defer="notes" class="md:col-span-2" />
                <div class="col-span-full">
                    <x-button type="submit" variant="primary">
                        {{ $guestId ? 'Update' : 'Create' }}
                    </x-button>
                    @if ($guestId)
                        <x-button variant="ghost" wire:click="resetForm" class="ml-2">Cancel</x-button>
                    @endif
                </div>
            </form>
        </x-card>

        <x-card header="Guest Registration Cards">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                    <tr class="text-left border-b">
                        <th>Name</th>
                        <th>Nationality</th>
                        <th>Passport</th>
                        <th>Phone</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($guests as $guest)
                        <tr class="border-b">
                            <td>{{ $guest->full_name }}</td>
                            <td>{{ $guest->nationality }}</td>
                            <td>{{ $guest->passport_number }}</td>
                            <td>{{ $guest->phone }}</td>
                            <td class="text-right space-x-2">
                                <x-button size="sm" wire:click="edit({{ $guest->id }})">Edit</x-button>
                                <x-button size="sm" variant="danger" wire:click="delete({{ $guest->id }})">Delete</x-button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-gray-500 py-4">No guests found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
