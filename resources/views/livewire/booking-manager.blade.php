<div class="flex flex-col gap-4">
    <x-card header="{{ $bookingId ? 'Update Booking' : 'New Booking' }}">
        <form wire:submit.prevent="save" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-select label="Room" wire:model.defer="room_id">
                <option value="">Select Room</option>
                @foreach ($rooms as $room)
                    <option value="{{ $room->id }}">
                        Room {{ $room->room_number }}
                    </option>
                @endforeach
            </x-select>

            <x-input type="date" label="Check-in Date" wire:model.defer="check_in" />
            <x-input type="date" label="Check-out Date" wire:model.defer="check_out" />

            <div class="md:col-span-2">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Guests</label>
                <livewire:guest-autocomplete :selectedGuests="$guest_ids" />
                <livewire:guest-modal />
            </div>

            <x-input type="number" label="Adults" wire:model.defer="adults" min="1" />
            <x-input type="number" label="Children" wire:model.defer="children" min="0" />

            <x-select label="Status" wire:model.defer="status">
                <option value="reserved">Reserved</option>
                <option value="checked_in">Checked In</option>
                <option value="checked_out">Checked Out</option>
                <option value="cancelled">Cancelled</option>
            </x-select>

            <x-textarea label="Notes" wire:model.defer="notes" class="md:col-span-2" />

            <div class="col-span-full">
                <x-button type="submit" variant="primary">
                    {{ $bookingId ? 'Update' : 'Create' }}
                </x-button>
                @if ($bookingId)
                    <x-button variant="ghost" wire:click="resetForm" class="ml-2">Cancel</x-button>
                @endif
            </div>
        </form>
    </x-card>

    <x-card header="Recent Bookings">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                <tr class="text-left border-b">
                    <th>Room</th>
                    <th>Guests</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($recentBookings as $booking)
                    <tr class="border-b">
                        <td>{{ $booking->room->room_number ?? '-' }}</td>
                        <td>
                            @foreach($booking->guests as $g)
                                <span class="inline-block">{{ $g->full_name }}</span>@if (!$loop->last), @endif
                            @endforeach
                        </td>
                        <td>{{ $booking->check_in }}</td>
                        <td>{{ $booking->check_out }}</td>
                        <td>{{ ucfirst($booking->status) }}</td>
                        <td class="text-right space-x-2">
                            <x-button size="sm" wire:click="edit({{ $booking->id }})">Edit</x-button>
                            <x-button size="sm" variant="danger" wire:click="delete({{ $booking->id }})">Delete</x-button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 py-4">No bookings found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </x-card>
</div>
