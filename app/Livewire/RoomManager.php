<?php

namespace App\Livewire;

use App\Models\Room;
use App\Models\RoomCategory;
use Livewire\Component;

class RoomManager extends Component
{
    public $roomId, $room_number, $room_category_id, $max_guests, $rate, $status = 'available';

    public function save()
    {
        $data = $this->validate([
            'room_number' => 'required|string|max:255',
            'room_category_id' => 'required|exists:room_categories,id',
            'max_guests' => 'required|integer|min:1',
            'rate' => 'required|numeric|min:0',
            'status' => 'required|in:available,occupied,maintenance',
        ]);

        Room::updateOrCreate(
            ['id' => $this->roomId],
            array_merge($data, ['team_id' => auth()->user()->team_id])
        );

        $this->resetForm();
    }

    public function edit($id)
    {
        $room = Room::findOrFail($id);
        $this->roomId = $room->id;
        $this->room_number = $room->room_number;
        $this->room_category_id = $room->room_category_id;
        $this->max_guests = $room->max_guests;
        $this->rate = $room->rate;
        $this->status = $room->status;
    }

    public function delete($id)
    {
        Room::findOrFail($id)->delete();
    }

    public function resetForm()
    {
        $this->reset(['roomId', 'room_number', 'room_category_id', 'max_guests', 'rate', 'status']);
    }

    public function render()
    {
        return view('livewire.room-manager', [
            'rooms' => Room::where('team_id', auth()->user()->team_id)->latest()->get(),
            'categories' => RoomCategory::where('team_id', auth()->user()->team_id)->get()
        ]);
    }
}
