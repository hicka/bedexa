<?php

namespace App\Livewire\Booking;

use App\Models\Booking;
use App\Models\BookingSource;
use App\Models\Guest;
use App\Models\Room;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Create extends Component
{
    // form fields
    public ?int $bookingId = null;
    public ?Booking $booking = null;   // expose to view & children

    public ?int $booking_source_id = null;
    public array $rooms = [['room_id' => null, 'check_in' => null, 'check_out' => null, 'price' => null]];
    public array $guest_ids = [];
    public string $status = 'reserved';
    public string $notes = '';
    public string $internal_notes = '';

    // dropdown sources
    public array $roomOptions = [];
    public Collection $guests;
    public Collection $sources;

    protected $listeners = ['guestsSelected' => 'updateGuestIds'];

    public function mount($booking = null)
    {
        $this->booking = $booking?->exists ? $booking : null;
        $this->bookingId = $this->booking?->id;

        $this->roomOptions = Room::with('type')->get()
            ->map(fn($r) => ['id' => $r->id, 'label' => $r->room_number . ' (' . $r->type->name . ')'])
            ->toArray();

        $this->sources = BookingSource::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);


        $this->guests = Guest::orderBy('full_name')->get();

        if ($booking && $booking->exists) {
            $this->bookingId = $booking->id;
            $this->status = $booking->status;
            $this->notes = $booking->notes;
            $this->internal_notes = $booking->internal_notes;
            $this->guest_ids = $booking->guests->pluck('id')->toArray();
            $this->rooms = $booking->rooms->map(fn($br) => [
                'room_id' => $br->room_id,
                'check_in' => $br->check_in->format('Y-m-d'),
                'check_out' => $br->check_out->format('Y-m-d'),
                'price' => $br->price,
            ])->toArray();
        }
    }

    /* ---- Room handlers ---- */
    public function addRoom()
    {
        $this->rooms[] = ['room_id' => null, 'check_in' => null, 'check_out' => null, 'price' => null];
    }

    /* ---- removes room ---- */
    public function removeRoom($i)
    {
        unset($this->rooms[$i]);
        $this->rooms = array_values($this->rooms);
    }

    /* ---- Guest autocomplete ---- */
    public function updateGuestIds($ids)
    {
        $this->guest_ids = $ids;
    }

    /* ---- Save Booking ---- */
    public function save()
    {
        try {
            $this->doSave();                 // move the existing logic here
        } catch (\Throwable $e) {
            // 1. Log the full error
            Log::error('Booking save failed', [
                'msg' => $e->getMessage(),
                'file' => $e->getFile() . ':' . $e->getLine(),
            ]);

            // 2. Show a flash so you see it immediately
            session()->flash('error', 'Error: ' . $e->getMessage());
            return;
        }
    }

    public function doSave()
    {
        $this->validate([
            'rooms' => 'required|array|min:1',
            'rooms.*.room_id' => 'required|exists:rooms,id',
            'rooms.*.check_in' => 'required|date',
            'rooms.*.check_out' => 'required|date|after_or_equal:rooms.*.check_in',
            'guest_ids' => 'required|array|min:1',
            'guest_ids.*' => 'exists:guests,id',
            'status' => 'required|in:reserved,checked_in,checked_out,cancelled',
        ]);

        $booking = Booking::updateOrCreate(
            ['id' => $this->bookingId],
            ['status' => $this->status, 'notes' => $this->notes, 'internal_notes' => $this->internal_notes, 'team_id' => auth()->user()->team_id]
        );

        // sync guests
        $booking->guests()->sync($this->guest_ids);

        // sync rooms
        $booking->rooms()->delete();
        foreach ($this->rooms as $room) {
            $booking->rooms()->create($room);
        }

        $totals = \App\Services\BookingTotalService::calculate($booking);
        $booking->fill($totals)->save();

        session()->flash('success', $this->bookingId ? 'Booking updated.' : 'Booking created.');
        return redirect()->route('bookings.index');
    }


    public function render()
    {
        return view('livewire.booking.create');
    }
}
