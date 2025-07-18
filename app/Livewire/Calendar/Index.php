<?php

namespace App\Livewire\Calendar;

use Livewire\Component;
use App\Models\{Room,BookingRoom};
use Carbon\Carbon;

class Index extends Component
{
    public string $month;    // format: 2024-06
    public ?int   $roomTypeFilter = null;
    public ?string $statusFilter  = null;  // reserved / occupied / etc.

    public function mount()
    {
        $this->month = now()->format('Y-m');
    }

    public function getDatesProperty()
    {
        $start = Carbon::createFromFormat('Y-m', $this->month)->startOfMonth();
        return collect(range(0, $start->daysInMonth - 1))
            ->map(fn($i) => $start->copy()->addDays($i));
    }

    public function render()
    {
        // rooms (optionally filtered by type)
        $rooms = Room::with('type')
            ->when($this->roomTypeFilter, fn($q) =>
            $q->where('room_type_id', $this->roomTypeFilter))
            ->orderBy('room_type_id')
            ->orderBy('room_number')
            ->get();

        // bookings overlapping current month
        $start = Carbon::createFromFormat('Y-m', $this->month)->startOfMonth();
        $end   = $start->copy()->endOfMonth();

        $bookings = BookingRoom::with(['room','booking'])
            ->where(function($q) use ($start,$end){
                $q->whereBetween('check_in',  [$start, $end])
                    ->orWhereBetween('check_out', [$start, $end])
                    ->orWhere(function($q) use ($start,$end){
                        $q->where('check_in','<=',$start)->where('check_out','>=',$end);
                    });
            })
            ->when($this->statusFilter, fn($q) =>
            $q->where('status',$this->statusFilter))
            ->get();

        return view('livewire.calendar.index', [
            'rooms'    => $rooms,
            'bookings' => $bookings->groupBy('room_id'),
            'dates'    => $this->dates,
        ]);
    }
}
