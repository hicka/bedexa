<div class="max-w-2xl mx-auto">
    <x-page-heading :title="$roomId ? 'Edit Room' : 'New Room'" />

    <x-card>
        <form wire:submit.prevent="save" class="space-y-4">
            <x-input label="Room Number" wire:model.defer="room_number" required />

            <x-select label="Room Type" wire:model.defer="room_type_id" required>
                <option value="">Select Room Type</option>
                @foreach ($roomTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </x-select>

            <x-select label="Status" wire:model.defer="status" required>
                <option value="available">Available</option>
                <option value="occupied">Occupied</option>
                <option value="maintenance">Maintenance</option>
            </x-select>

            <div class="flex justify-between">
                <x-button type="submit" variant="primary">
                    {{ $roomId ? 'Update' : 'Create' }}
                </x-button>
                <x-button href="{{ route('rooms.index') }}" variant="ghost">Cancel</x-button>
            </div>
        </form>
    </x-card>
</div>
