<?php

namespace App\Livewire;

use App\Models\Guest;
use Livewire\Component;

class GuestAutocomplete extends Component
{
    public $search = '';
    public $results = [];
    public $selectedGuests = [];

    public function updatedSearch()
    {
        $this->results = Guest::where('full_name', 'like', "%{$this->search}%")
            ->orWhere('passport_number', 'like', "%{$this->search}%")
            ->limit(5)
            ->get();
    }

    public function selectGuest($id)
    {
        $guest = Guest::find($id);

        if ($guest && !collect($this->selectedGuests)->pluck('id')->contains($id)) {
            $this->selectedGuests[] = ['id' => $guest->id, 'name' => $guest->full_name];
            $this->dispatch('guestsSelected', collect($this->selectedGuests)->pluck('id')->toArray());

        }

        $this->reset('search', 'results');
    }

    public function removeGuest($id)
    {
        $this->selectedGuests = collect($this->selectedGuests)->reject(fn($g) => $g['id'] == $id)->values()->all();
        $this->dispatch('guestsSelected', collect($this->selectedGuests)->pluck('id')->toArray());
    }

    public function render()
    {
        return view('livewire.guest-autocomplete');
    }
}
