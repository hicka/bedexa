<?php

namespace App\Livewire\Calendar;

use Illuminate\Support\Collection;
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

    /* ───── Month navigation actions ───── */
    public function prevMonth(): void
    {
        $this->month = \Carbon\Carbon::createFromFormat('Y-m', $this->month)
            ->subMonth()->format('Y-m');
    }

    public function nextMonth(): void
    {
        $this->month = \Carbon\Carbon::createFromFormat('Y-m', $this->month)
            ->addMonth()->format('Y-m');
    }

    public function gotoMonth(string $value): void
    {
        // $value comes from <input type="month"> e.g. "2025-04"
        $this->month = $value;
    }

    public function getDatesProperty()
    {
        $start = Carbon::createFromFormat('Y-m', $this->month)->startOfMonth();
        return collect(range(0, $start->daysInMonth - 1))
            ->map(fn($i) => $start->copy()->addDays($i));
    }

    public function getBookingsProperty(): Collection
    {
        $start = Carbon::createFromFormat('Y-m', $this->month)->startOfMonth();
        $end   = $start->copy()->endOfMonth();

        return BookingRoom::with(['room','booking'])
            ->get()
            ->groupBy('room_id')
            ->mapWithKeys(fn ($items, $key) => [(int) $key => $items]);
    }

    public function render()
    {
        $rooms = Room::with('type')
            ->when($this->roomTypeFilter, fn($q) =>
            $q->where('room_type_id', $this->roomTypeFilter))
            ->orderBy('room_type_id')
            ->orderBy('room_number')
            ->get();

        return view('livewire.calendar.index', [
            'rooms'    => $rooms,
            'bookings' => $this->bookings,   // ← computed property
            'dates'    => $this->dates,
        ]);
    }
}
