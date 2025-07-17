<?php
namespace App\Livewire;

use App\Models\Guest;
use Livewire\Component;

class GuestModal extends Component
{
    public bool $open = false;

    public string $full_name = '';
    public string $email = '';
    public string $phone = '';
    public string $nationality = '';
    public string $passport_number = '';
    public string $address = '';
    public string $notes = '';

    protected $rules = [
        'full_name' => 'required|string|max:255',
        'email' => 'nullable|email|max:255',
        'phone' => 'nullable|string|max:50',
        'nationality' => 'nullable|string|max:100',
        'passport_number' => 'nullable|string|max:100',
        'address' => 'nullable|string|max:255',
        'notes' => 'nullable|string|max:500',
    ];

    public function save()
    {
        $guest = Guest::create($this->validate());

        $this->dispatch('guestCreated', $guest->id, $guest->full_name)->toParent();

        $this->resetExcept('open');
        $this->open = false;
    }

    #[\Livewire\Attributes\On('openNewGuestModal')]
    public function openModal()
    {
        $this->resetExcept('open');
        $this->open = true;
    }

    public function render()
    {
        return view('livewire.guest-modal');
    }
}
