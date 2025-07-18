<?php

namespace App\Livewire\Guest;

use App\Models\Guest;
use Livewire\Component;

class Create extends Component
{
    public ?Guest $guest = null;

    public string $full_name      = '';
    public string $passport_number= '';
    public string $nationality    = '';
    public string $phone          = '';
    public ?string $address       = null;
    public ?string $notes         = null;
    public string $type           = 'foreign';   // foreign / local
    public ?string $gender        = null;
    public ?string $dob           = null;        // Y-m-d
    public ?string $id_card       = null;        // for locals

    public function mount($guest = null)
    {
        if ($guest && $guest->exists) {
            $this->guest            = $guest;
            $this->full_name        = $guest->full_name;
            $this->passport_number  = $guest->passport_number;
            $this->nationality      = $guest->nationality;
            $this->phone            = $guest->phone ?? '';
            $this->address          = $guest->address;
            $this->notes            = $guest->notes;
            $this->type             = $guest->type;
            $this->gender           = $guest->gender;
            $this->dob              = $guest->date_of_birth?->format('Y-m-d');
            $this->id_card          = $guest->id_card;
        }
    }

    public function save()
    {
        $this->validate([
            'full_name'       => 'required|string|max:255',
            'passport_number' => 'nullable|string|max:50',
            'nationality'     => 'required|string|max:100',
            'phone'           => 'nullable|string|max:50',
            'dob'             => 'nullable|date',
        ]);

        Guest::updateOrCreate(
            ['id' => $this->guest?->id],
            [
                'team_id'         => auth()->user()->team_id,
                'full_name'       => $this->full_name,
                'passport_number' => $this->passport_number ?: null,
                'nationality'     => $this->nationality,
                'phone'           => $this->phone ?: null,
                'address'         => $this->address,
                'notes'           => $this->notes,
                'type'            => $this->type,
                'gender'          => $this->gender,
                'date_of_birth'             => $this->dob,
                'id_card'         => $this->id_card,
            ]
        );

        session()->flash('success', $this->guest ? 'Guest updated.' : 'Guest created.');
        return redirect()->route('guests.index');
    }

    public function render()
    {
        return view('livewire.guest.create');
    }
}
