<div class="max-w-4xl mx-auto space-y-8">

    {{-- ───────────── Page Heading ───────────── --}}
    <x-page-heading :title="$bookingId ? 'Edit Booking' : 'New Booking'">
        <x-button variant="ghost" href="{{ route('bookings.index') }}">Back to list</x-button>
    </x-page-heading>

    {{-- ───────────── Rooms Section ───────────── --}}
    <x-card>
        <x-slot name="header">Rooms</x-slot>

        <div class="space-y-6">
            @foreach ($rooms as $i => $room)
                <div
                    wire:key="room-{{ $i }}"
                    class="border border-gray-200 dark:border-slate-700 rounded-xl p-4 grid gap-4 md:grid-cols-5 items-end"
                >
                    <x-select
                        label="Room"
                        wire:model.live="rooms.{{ $i }}.room_id"
                        class="md:col-span-2"
                    >
                        <option value="">Select…</option>
                        @foreach ($roomOptions as $opt)
                            <option value="{{ $opt['id'] }}">{{ $opt['label'] }}</option>
                        @endforeach
                    </x-select>

                    <x-input
                        type="date"
                        label="Check-in"
                        wire:model.live="rooms.{{ $i }}.check_in"
                    />

                    <x-input
                        type="date"
                        label="Check-out"
                        wire:model.live="rooms.{{ $i }}.check_out"
                    />

                    <x-input
                        type="number"
                        label="Price"
                        step="0.01"
                        min="0"
                        wire:model.live="rooms.{{ $i }}.price"
                    />

                    <div class="md:col-span-5 text-right">
                        <x-button
                            size="xs"
                            variant="danger"
                            type="button"
                            wire:click="removeRoom({{ $i }})"
                        >
                            Remove
                        </x-button>
                    </div>
                </div>
            @endforeach

            <x-button
                size="sm"
                variant="outline"
                type="button"
                wire:click="addRoom"
            >
                + Add Room
            </x-button>
        </div>
    </x-card>

    {{-- ───────────── Guests Section ───────────── --}}
    <x-card>
        <x-slot name="header">Guests</x-slot>

        <div class="space-y-4">
            <label class="text-sm font-medium block">Select / Add Guest(s)</label>
            <livewire:guest-autocomplete :selectedGuests="$guest_ids" />
        </div>
    </x-card>

    {{-- ───────────── Booking Details Section ───────────── --}}
    <x-card>
        <x-slot name="header">Booking Details</x-slot>

        <div class="grid gap-4 md:grid-cols-2">
            <x-select label="Status" wire:model.live="status">
                <option value="reserved">Reserved</option>
                <option value="checked_in">Checked-in</option>
                <option value="checked_out">Checked-out</option>
                <option value="cancelled">Cancelled</option>
            </x-select>

            <x-select label="Source" wire:model.live="booking_source_id">
                <option value="">Select source…</option>
                @foreach ($sources as $src)
                    <option value="{{ $src->id }}">{{ $src->name }}</option>
                @endforeach
            </x-select>
        </div>

        <div class="mt-6 grid gap-4">
            <x-textarea
                label="Guest-visible Notes"
                rows="3"
                wire:model.live="notes"
            />
            <x-textarea
                label="Internal Notes (staff only)"
                rows="3"
                wire:model.live="internal_notes"
            />
        </div>
    </x-card>

    {{-- ───────────── Actions ───────────── --}}
    <div class="flex justify-end gap-3">
        <x-button variant="ghost" href="{{ route('bookings.index') }}">Cancel</x-button>
        <x-button variant="primary" wire:click="save">
            {{ $bookingId ? 'Update Booking' : 'Create Booking' }}
        </x-button>
    </div>

</div>
