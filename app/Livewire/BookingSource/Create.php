<?php

namespace App\Livewire\BookingSource;

use App\Models\BookingSource;
use Livewire\Component;

class Create extends Component
{
    public ?BookingSource $source = null;   // null = create mode
    public string $name = '';
    public string $code = '';
    public bool   $is_active = true;

    public function mount($source = null)
    {
        if ($source && $source->exists) {
            $this->source     = $source;
            $this->name       = $source->name;
            $this->code       = $source->code ?? '';
            $this->is_active  = $source->is_active;
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
        ]);

        BookingSource::updateOrCreate(
            ['id' => $this->source?->id],
            [
                'team_id'   => auth()->user()->team_id,
                'name'      => $this->name,
                'code'      => $this->code ?: null,
                'is_active' => $this->is_active,
            ]
        );

        session()->flash('success', $this->source ? 'Source updated.' : 'Source created.');
        return redirect()->route('sources.index');
    }


    public function render()
    {
        return view('livewire.booking-source.create');
    }
}
