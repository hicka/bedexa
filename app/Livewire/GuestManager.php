<?php

namespace App\Livewire;

use App\Models\Guest;
use Livewire\Component;

class GuestManager extends Component
{
    public $guestId, $full_name, $email, $phone, $nationality, $passport_number, $address, $notes;

    public function save()
    {
        $data = $this->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'nationality' => 'nullable|string|max:100',
            'passport_number' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        Guest::updateOrCreate(
            ['id' => $this->guestId],
            array_merge($data, ['team_id' => auth()->user()->team_id])
        );

        $this->resetForm();
    }

    public function edit($id)
    {
        $guest = Guest::findOrFail($id);
        $this->guestId = $guest->id;
        $this->fill($guest->only(array_keys($this->getPublicProperties())));
    }

    public function delete($id)
    {
        Guest::findOrFail($id)->delete();
    }

    public function resetForm()
    {
        $this->reset([
            'guestId', 'full_name', 'email', 'phone',
            'nationality', 'passport_number', 'address', 'notes'
        ]);
    }

    public function render()
    {
        return view('livewire.guest-manager', [
            'guests' => Guest::where('team_id', auth()->user()->team_id)->latest()->get()
        ]);
    }
}
