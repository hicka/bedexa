<?php

namespace App\Livewire\Booking;

use App\Models\Booking;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch() { $this->resetPage(); }

    public function delete($id)
    {
        Booking::findOrFail($id)->delete();
        session()->flash('success', 'Booking deleted.');
    }

    public function render()
    {
        $bookings = Booking::with(['rooms.room', 'guests'])
            ->where('id', 'like', '%'.$this->search.'%')
            ->orderByDesc('id')
            ->paginate(10);

        return view('livewire.booking.index', compact('bookings'));
    }
}
