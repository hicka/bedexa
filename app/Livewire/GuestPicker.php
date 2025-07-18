<?php

namespace App\Livewire;

use App\Models\Guest;
use Livewire\Component;

class GuestPicker extends Component
{
    public string $search = '';

    #[\Livewire\Attributes\Modelable]          // no alias → uses property name
    public array $guest_ids = [];

    public bool   $showModal = false;

    /* ------- search ------- */
    public function getResultsProperty()
    {
        if ($this->search === '') return [];
        return Guest::where('full_name', 'like', '%'.$this->search.'%')
            ->orWhere('passport_number', 'like', '%'.$this->search.'%')
            ->limit(10)->get();
    }

// adjust methods:
    public function selectGuest($id)
    {
        if (!in_array($id, $this->guest_ids)) {
            $this->guest_ids[] = $id;
        }
        $this->reset('search');
    }

    public function removeGuest($id)
    {
        $this->guest_ids = array_diff($this->guest_ids, [$id]);
    }

    /* ------- modal ------- */
    public string $new_name = '', $new_passport = '', $new_nationality = '';

    public function saveGuest()
    {
        $guest = Guest::create([
            'team_id'        => auth()->user()->team_id,
            'full_name'      => $this->new_name,
            'passport_number'=> $this->new_passport,
            'nationality'    => $this->new_nationality,
            'type'           => 'foreign',
        ]);

        $this->guest_ids[] = $guest->id;
        $this->reset('search');
        $this->reset(['showModal','new_name','new_passport','new_nationality']);
    }

    public function getSelectedMapProperty(): array
    {
        return Guest::whereIn('id', $this->guest_ids)
            ->pluck('full_name','id')
            ->toArray();
    }

    public function render()
    {
        return view('livewire.guest-picker');
    }
}
