
    <div class="flex flex-col gap-4">
        <x-card header="{{ $roomId ? 'Update Room' : 'New Room' }}">
            <form wire:submit.prevent="save" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input label="Room Number" wire:model.defer="room_number" />
                <x-select label="Category" wire:model.defer="room_category_id">
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </x-select>
                <x-input label="Max Guests" type="number" wire:model.defer="max_guests" />
                <x-input label="Rate (MVR)" type="number" wire:model.defer="rate" />
                <x-select label="Status" wire:model.defer="status">
                    <option value="available">Available</option>
                    <option value="occupied">Occupied</option>
                    <option value="maintenance">Maintenance</option>
                </x-select>

                <div class="col-span-full">
                    <x-button type="submit" variant="primary">
                        {{ $roomId ? 'Update' : 'Create' }}
                    </x-button>
                    @if ($roomId)
                        <x-button variant="ghost" wire:click="resetForm" class="ml-2">Cancel</x-button>
                    @endif
                </div>
            </form>
        </x-card>

        <x-card header="Existing Rooms">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                    <tr class="text-left border-b">
                        <th>Room</th>
                        <th>Category</th>
                        <th>Rate</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($rooms as $room)
                        <tr class="border-b">
                            <td>{{ $room->room_number }}</td>
                            <td>{{ $room->category->name ?? '-' }}</td>
                            <td>MVR {{ number_format($room->rate, 2) }}</td>
                            <td>{{ ucfirst($room->status) }}</td>
                            <td class="text-right space-x-2">
                                <x-button size="sm" wire:click="edit({{ $room->id }})">Edit</x-button>
                                <x-button size="sm" variant="danger" wire:click="delete({{ $room->id }})">Delete</x-button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-gray-500">No rooms found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>

