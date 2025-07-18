<?php

namespace App\Livewire\Booking;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Support\Carbon;
use Livewire\Component;

class QuickCreate extends Component
{
    public bool   $open      = false;   // modal visibility (bound with wire:model)
    public ?int   $room_id   = null;
    public string $check_in  = '';
    public string $check_out = '';
    public string $status    = 'reserved';

    protected $listeners = ['openQuickBooking'];


    public function openQuickBooking($roomId, $date): void
    {
        $this->room_id   = $roomId;
        $this->check_in  = $date;
        $this->check_out = Carbon::parse($this->check_in)->addDay()->toDateString();
        $this->open      = true;
    }

    public function save()
    {
        $this->validate([
            'room_id'   => 'required|exists:rooms,id',
            'check_in'  => 'required|date',
            'check_out' => 'required|date|after:check_in',
        ]);

        // create bare-bones booking with one room – staff can edit later
        $booking = Booking::create([
            'team_id' => auth()->user()->team_id,
            'status'  => $this->status,
        ]);

        $booking->rooms()->create([
            'room_id'   => $this->room_id,
            'check_in'  => $this->check_in,
            'check_out' => $this->check_out,
        ]);

        session()->flash('success','Booking created.');
        $this->open = false;

        // let calendar refresh
        $this->dispatch('bookingCreated');
    }

    public function render()
    {
        return view('livewire.booking.quick-create',[
            'room' => Room::find($this->room_id),
        ]);
    }
}
