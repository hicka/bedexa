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
    {{-- Guests --}}
    <x-card>
        <x-slot name="header">Guests</x-slot>
        <livewire:guest-picker wire:model.live="guest_ids" />
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

    @if($bookingId)
        <livewire:booking.payments :booking="$booking" wire:key="payments-{{ $bookingId }}" />
    @endif


    {{-- Real-time totals ---------------------------------------------------}}
    <x-card x-data="guest--{{count($this->guest_ids)}}" class="md:col-span-2 bg-slate-50 dark:bg-slate-800">
        <div class="flex flex-col gap-2 text-sm">
            <div class="flex justify-between">
                <span>Room Sub-total</span>
                <span class="font-medium">${{ number_format($subTotal, 2) }}</span>
            </div>
            <div class="flex justify-between">
                <span>Service Charge</span>
                <span>${{ number_format($serviceCharge,2) }}</span>
            </div>
            <div class="flex justify-between">
                <span>TGST (12%)</span>
                <span>${{ number_format($tgst, 2) }}</span>
            </div>
            <div class="flex justify-between">
                <span>Green Tax</span>
                <span>${{ number_format($greenTax, 2) }}</span>
            </div>
            <hr class="my-1 border-slate-300 dark:border-slate-600">
            <div class="flex justify-between text-lg font-semibold">
                <span>Total</span>
                <span>${{ number_format($total, 2) }}</span>
            </div>
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
