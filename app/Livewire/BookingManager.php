<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\Guest;
use App\Models\Room;
use Illuminate\Support\Collection;
use Livewire\Component;

class BookingManager extends Component
{
    public ?int $bookingId = null;

    public $room_id;
    public $guest_ids = [];
    public $check_in;
    public $check_out;
    public $adults = 1;
    public $children = 0;
    public $status = 'reserved';
    public $notes;

    public Collection $rooms;
    public Collection $guests;

    protected $listeners = ['guestsSelected' => 'updateGuestIds', 'openNewGuestModal' => 'openNewGuestModal'];


    public function mount()
    {
        $this->rooms = Room::orderBy('room_number')->get();
        $this->guests = Guest::orderBy('full_name')->get();
    }

    public function render()
    {
        $recentBookings = Booking::with(['room', 'guests'])->latest()->limit(10)->get();

        return view('livewire.booking-manager', [
            'recentBookings' => $recentBookings,
        ]);
    }

    public function updateGuestIds($ids)
    {
        $this->guest_ids = $ids;
    }

    #[\Livewire\Attributes\On('guestCreated')]
    public function addCreatedGuest($id, $name)
    {
        $this->guest_ids[] = $id;
        // Optionally show toast or confirmation
    }

    public function save()
    {
        $this->validate([
            'room_id' => 'required|exists:rooms,id',
            'guest_ids' => 'required|array|min:1',
            'guest_ids.*' => 'exists:guests,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after_or_equal:check_in',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'status' => 'required|in:reserved,checked_in,checked_out,cancelled',
            'notes' => 'nullable|string',
        ]);

        $booking = Booking::updateOrCreate(
            ['id' => $this->bookingId],
            [
                'room_id' => $this->room_id,
                'check_in' => $this->check_in,
                'check_out' => $this->check_out,
                'adults' => $this->adults,
                'children' => $this->children,
                'status' => $this->status,
                'notes' => $this->notes,
            ]
        );

        $booking->guests()->sync($this->guest_ids);

        session()->flash('success', $this->bookingId ? 'Booking updated.' : 'Booking created.');

        $this->resetForm();
    }

    public function edit($id)
    {
        $booking = Booking::with('guests')->findOrFail($id);

        $this->bookingId = $booking->id;
        $this->room_id = $booking->room_id;
        $this->guest_ids = $booking->guests->pluck('id')->toArray();
        $this->check_in = $booking->check_in;
        $this->check_out = $booking->check_out;
        $this->adults = $booking->adults;
        $this->children = $booking->children;
        $this->status = $booking->status;
        $this->notes = $booking->notes;
    }

    public function delete($id)
    {
        Booking::findOrFail($id)->delete();

        session()->flash('success', 'Booking deleted.');
    }

    public function updatedCheckIn()
    {
        $this->filterAvailableRooms();
    }

    public function updatedCheckOut()
    {
        $this->filterAvailableRooms();
    }

    protected function filterAvailableRooms()
    {
        if (!$this->check_in || !$this->check_out) {
            $this->rooms = collect();
            return;
        }

        $this->rooms = Room::whereDoesntHave('bookings', function ($q) {
            $q->where(function ($query) {
                $query->whereBetween('check_in', [$this->check_in, $this->check_out])
                    ->orWhereBetween('check_out', [$this->check_in, $this->check_out])
                    ->orWhere(function ($query) {
                        $query->where('check_in', '<=', $this->check_in)
                            ->where('check_out', '>=', $this->check_out);
                    });
            });
        })->orderBy('room_number')->get();
    }

    public function resetForm()
    {
        $this->reset([
            'bookingId',
            'room_id',
            'guest_ids',
            'check_in',
            'check_out',
            'adults',
            'children',
            'status',
            'notes',
        ]);
    }
}
