<?php

namespace App\Livewire\RoomType;

use App\Models\RoomType;
use Livewire\Component;

class Create extends Component
{
    public $roomTypeId;
    public $name;
    public $base_price;
    public $description;

    public function mount($id = null)
    {
        if ($id) {
            $roomType = RoomType::findOrFail($id);
            $this->roomTypeId = $roomType->id;
            $this->name = $roomType->name;
            $this->base_price = $roomType->base_price;
            $this->description = $roomType->description;
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'base_price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        RoomType::updateOrCreate(
            ['id' => $this->roomTypeId],
            [
                'name' => $this->name,
                'base_price' => $this->base_price,
                'description' => $this->description,
            ]
        );

        session()->flash('success', $this->roomTypeId ? 'Room type updated.' : 'Room type created.');
        return redirect()->route('room-types.index');
    }

    public function render()
    {
        return view('livewire.room-type.create');
    }
}
