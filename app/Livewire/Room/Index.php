<?php

namespace App\Livewire\Room;

use App\Models\Room;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        Room::findOrFail($id)->delete();
        session()->flash('success', 'Room deleted successfully.');
    }

    public function render()
    {
        $rooms = Room::with('type')
            ->where('room_number', 'like', "%{$this->search}%")
            ->orderBy('room_number')
            ->paginate(10);

        return view('livewire.room.index', [
            'rooms' => $rooms,
        ]);
    }
}
