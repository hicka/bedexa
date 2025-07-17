<?php

namespace App\Livewire;

use App\Models\RoomCategory;
use Livewire\Component;

class RoomCategoryManager extends Component
{
    public $name, $description, $default_rate, $roomCategoryId;

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'default_rate' => 'required|numeric',
        ]);

        RoomCategory::updateOrCreate(['id' => $this->roomCategoryId], [
            'name' => $this->name,
            'description' => $this->description,
            'default_rate' => $this->default_rate,
            'team_id' => auth()->user()->team_id,
        ]);

        $this->resetForm();
    }

    public function edit($id)
    {
        $cat = RoomCategory::findOrFail($id);
        $this->roomCategoryId = $cat->id;
        $this->name = $cat->name;
        $this->description = $cat->description;
        $this->default_rate = $cat->default_rate;
    }

    public function delete($id)
    {
        RoomCategory::findOrFail($id)->delete();
    }

    public function resetForm()
    {
        $this->reset(['name', 'description', 'default_rate', 'roomCategoryId']);
    }

    public function render()
    {
        return view('livewire.room-category-manager', [
            'categories' => RoomCategory::where('team_id', auth()->user()->team_id)->get()
        ]);
    }
}
