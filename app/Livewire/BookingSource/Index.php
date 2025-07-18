<?php

namespace App\Livewire\BookingSource;

use App\Models\BookingSource;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch() { $this->resetPage(); }

    public function toggle($id)
    {
        $src = BookingSource::findOrFail($id);
        $src->update(['is_active' => ! $src->is_active]);
    }

    public function delete($id)
    {
        BookingSource::findOrFail($id)->delete();
        session()->flash('success','Source deleted.');
    }

    public function render()
    {
        $sources = BookingSource::where('name','like','%'.$this->search.'%')
            ->orderBy('name')->paginate(10);

        return view('livewire.booking-source.index', compact('sources'));
    }

}
