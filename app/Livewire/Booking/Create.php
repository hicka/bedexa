<?php

namespace App\Livewire\Booking;

use App\Models\Booking;
use App\Models\Guest;
use App\Models\Room;
use Illuminate\Support\Collection;
use Livewire\Component;

class Create extends Component
{
    // form fields
    public ?int $bookingId = null;
    public array $rooms = [ ['room_id'=>null,'check_in'=>null,'check_out'=>null,'price'=>null] ];
    public array $guest_ids = [];
    public string $status = 'reserved';
    public string $notes = '';
    public string $internal_notes = '';

    // dropdown sources
    public array $roomOptions = [];
    public Collection $guests;

    public function mount($existingBooking = null)
    {
        $booking = $existingBooking;         // alias for clarity

        $this->roomOptions = Room::with('type')->get()
            ->map(fn($r)=>['id'=>$r->id,'label'=>$r->room_number.' ('.$r->type->name.')'])
            ->toArray();

        $this->guests = Guest::orderBy('full_name')->get();

        if ($booking && $booking->exists) {
            $this->bookingId = $booking->id;
            $this->status = $booking->status;
            $this->notes = $booking->notes;
            $this->internal_notes = $booking->internal_notes;
            $this->guest_ids = $booking->guests->pluck('id')->toArray();
            $this->rooms = $booking->rooms->map(fn($br)=>[
                'room_id'=>$br->room_id,
                'check_in'=>$br->check_in->format('Y-m-d'),
                'check_out'=>$br->check_out->format('Y-m-d'),
                'price'=>$br->price,
            ])->toArray();
        }
    }

    /* ---- Room handlers ---- */
    public function addRoom()   { $this->rooms[] = ['room_id'=>null,'check_in'=>null,'check_out'=>null,'price'=>null]; }
    public function removeRoom($i){ unset($this->rooms[$i]); $this->rooms = array_values($this->rooms); }

    /* ---- Guest autocomplete ---- */
    public function updateGuestIds($ids){ $this->guest_ids=$ids; }

    /* ---- Save Booking ---- */
    public function save()
    {
        $this->validate([
            'rooms'               => 'required|array|min:1',
            'rooms.*.room_id'     => 'required|exists:rooms,id',
            'rooms.*.check_in'    => 'required|date',
            'rooms.*.check_out'   => 'required|date|after_or_equal:rooms.*.check_in',
            'guest_ids'           => 'required|array|min:1',
            'guest_ids.*'         => 'exists:guests,id',
            'status'              => 'required|in:reserved,checked_in,checked_out,cancelled',
        ]);

        $booking = Booking::updateOrCreate(
            ['id'=>$this->bookingId],
            ['status'=>$this->status,'notes'=>$this->notes,'internal_notes'=>$this->internal_notes,'team_id'=>auth()->user()->currentTeam->id]
        );

        // sync guests
        $booking->guests()->sync($this->guest_ids);

        // sync rooms
        $booking->rooms()->delete();
        foreach($this->rooms as $room){
            $booking->rooms()->create($room);
        }

        session()->flash('success', $this->bookingId ? 'Booking updated.' : 'Booking created.');
        return redirect()->route('bookings.index');
    }

    public function render()
    {
        return view('livewire.booking.create');
    }
}
