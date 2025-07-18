<div class="bg-white dark:bg-slate-900 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700">
    <x-page-heading title="Bookings">
        <x-button href="{{ route('bookings.create') }}" variant="primary">+ New Booking</x-button>
    </x-page-heading>

    <x-input label="Search" wire:model.live.debounce.300ms="search"
             placeholder="Search by Booking ID…" class="mb-4" />

    <table class="min-w-full text-sm">
        <thead>
        <tr class="border-b">
            <th class="py-2">ID</th>
            <th class="py-2">Rooms</th>
            <th class="py-2">Guests</th>
            <th class="py-2">Status</th>
            <th class="py-2 text-right">Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($bookings as $booking)
            <tr class="border-b">
                <td class="py-2">{{ $booking->id }}</td>
                <td class="py-2">
                    @foreach($booking->rooms as $br)
                        <div>{{ $br->room->room_number }}: {{ $br->check_in }} → {{ $br->check_out }}</div>
                    @endforeach
                </td>
                <td class="py-2">
                    @foreach($booking->guests as $g)
                        <span>{{ $g->full_name }}</span>@if(!$loop->last), @endif
                    @endforeach
                </td>
                <td class="py-2 capitalize">{{ str_replace('_',' ',$booking->status) }}</td>
                <td class="py-2 text-right space-x-2">
                    <x-button size="sm" href="{{ route('bookings.edit', $booking) }}">Edit</x-button>
                    <x-button size="sm" variant="danger" wire:click="delete({{ $booking->id }})">Delete</x-button>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="py-6 text-center text-gray-500">No bookings found.</td></tr>
        @endforelse
        </tbody>
    </table>

    <div class="mt-4">{{ $bookings->links() }}</div>
</div>
