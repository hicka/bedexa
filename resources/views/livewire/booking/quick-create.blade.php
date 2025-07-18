<x-modal wire:model="open" title="Quick Booking">
    <div class="space-y-4">
        <div>
            <label class="text-sm font-medium block mb-1">Room</label>
            <span class="text-sm">{{ $room?->room_number }}</span>
        </div>

        <x-input type="date" label="Check-in"  wire:model.live="check_in" />
        <x-input type="date" label="Check-out" wire:model.live="check_out" />

        <x-select label="Status" wire:model.live="status">
            <option value="reserved">Reserved</option>
            <option value="checked_in">Checked-in</option>
        </x-select>

        <div class="flex justify-end gap-2">
            <x-button variant="ghost" wire:click="$set('open',false)">Cancel</x-button>
            <x-button variant="primary" wire:click="save">Create</x-button>
        </div>
    </div>
</x-modal>
