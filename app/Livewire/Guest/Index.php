<?php

namespace App\Livewire\Guest;

use App\Models\Guest;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch() { $this->resetPage(); }

    public function delete($id)
    {
        Guest::findOrFail($id)->delete();
        session()->flash('success', 'Guest deleted.');
    }

    public function render()
    {
        $guests = Guest::where('full_name', 'like', '%' . $this->search . '%')
            ->orWhere('passport_number', 'like', '%' . $this->search . '%')
            ->orderBy('full_name')
            ->paginate(10);

        return view('livewire.guest.index', compact('guests'));
    }
}
