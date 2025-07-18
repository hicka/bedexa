<div class="max-w-3xl mx-auto">
    <x-page-heading :title="$bookingId ? 'Edit Booking' : 'New Booking'" />

    <x-card>
        <form wire:submit.prevent="save" class="space-y-6">
            {{-- Dynamic Rooms --}}
            <div class="space-y-4">
                @foreach ($rooms as $i=>$room)
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end border border-gray-200 dark:border-slate-700 p-4 rounded-xl">
                        <x-select label="Room" wire:model.live="rooms.{{ $i }}.room_id">
                            <option value="">Select room</option>
                            @foreach($roomOptions as $opt)
                                <option value="{{ $opt['id'] }}">{{ $opt['label'] }}</option>
                            @endforeach
                        </x-select>

                        <x-input type="date" label="Check-in"  wire:model.live="rooms.{{ $i }}.check_in" />
                        <x-input type="date" label="Check-out" wire:model.live="rooms.{{ $i }}.check_out" />
                        <x-input type="number" label="Price"    wire:model.live="rooms.{{ $i }}.price" step="0.01" />

                        <div class="md:col-span-4 text-right">
                            <x-button size="xs" variant="danger" type="button" wire:click="removeRoom({{ $i }})">Remove</x-button>
                        </div>
                    </div>
                @endforeach

                <x-button size="sm" variant="outline" type="button" wire:click="addRoom">+ Add Room</x-button>
            </div>

            {{-- Guest selection --}}
            <div>
                <label class="text-sm font-medium mb-1 block">Guests</label>
                <livewire:guest-autocomplete :selectedGuests="$guest_ids" />
            </div>

            {{-- Status & Notes --}}
            <x-select label="Status" wire:model.live="status">
                <option value="reserved">Reserved</option>
                <option value="checked_in">Checked-in</option>
                <option value="checked_out">Checked-out</option>
                <option value="cancelled">Cancelled</option>
            </x-select>

            <x-textarea label="Notes (visible)" wire:model.live="notes" />
            <x-textarea label="Internal Notes (staff-only)" wire:model.live="internal_notes" />

            <div class="flex justify-end space-x-2">
                <x-button variant="primary" type="submit">{{ $bookingId ? 'Update' : 'Create' }}</x-button>
                <x-button variant="ghost" href="{{ route('bookings.index') }}">Cancel</x-button>
            </div>
        </form>
    </x-card>
</div>
