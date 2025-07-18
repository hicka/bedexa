<?php

namespace App\Livewire\RoomType;

use App\Models\RoomType;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $roomTypes = RoomType::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.room-type.index', [
            'roomTypes' => $roomTypes,
        ]);
    }

    public function delete($id)
    {
        RoomType::findOrFail($id)->delete();
        session()->flash('success', 'Room type deleted successfully.');
    }

}
