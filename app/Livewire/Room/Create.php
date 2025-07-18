<?php

namespace App\Livewire\Room;

use App\Models\Room;
use App\Models\RoomType;
use Livewire\Component;

class Create extends Component
{
    public ?int $roomId = null;

    public string $room_number = '';
    public ?int $room_type_id = null;
    public string $status = 'available';

    public $roomTypes;

    public function mount($room = null)
    {
        $this->roomTypes = RoomType::orderBy('name')->get();

        if ($room) {
            $this->roomId = $room->id;
            $this->room_number = $room->room_number;
            $this->room_type_id = $room->room_type_id;
            $this->status = $room->status;
        }
    }

    public function render()
    {
        return view('livewire.room.create');
    }

    public function save()
    {
        $this->validate([
            'room_number' => 'required|string|max:255|unique:rooms,room_number,' . $this->roomId,
            'room_type_id' => 'required|exists:room_types,id',
            'status' => 'required|in:available,occupied,maintenance',
        ]);

        $room = Room::updateOrCreate(
            ['id' => $this->roomId],
            [
                'room_number' => $this->room_number,
                'room_type_id' => $this->room_type_id,
                'status' => $this->status,
            ]
        );

        session()->flash('success', $this->roomId ? 'Room updated successfully.' : 'Room created successfully.');

        return redirect()->route('rooms.index');
    }
}
