<div x-data class="space-y-2">

    {{-- Search box --}}
    <x-input
        label="Search Guest"
        wire:model.live.debounce.300ms="search"
        placeholder="Type name or passport..."
    />

    {{-- Result list --}}
    @if($this->results)
        <ul class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded shadow max-h-60 overflow-auto">
            @forelse($this->results as $g)
                <li wire:click="selectGuest({{ $g->id }})"
                    class="px-4 py-2 cursor-pointer hover:bg-gray-100 dark:hover:bg-slate-700">
                    {{ $g->full_name }} ({{ $g->passport_number }})
                </li>
            @empty
                <li class="px-4 py-2 text-gray-500">
                    No results.
                    <a href="#" wire:click="$set('showModal', true)" class="underline">Add new guest</a>
                </li>
            @endforelse
        </ul>
    @endif

    {{-- Selected chips --}}
    <div class="flex flex-wrap gap-2">
        @foreach ($this->selectedMap as $id => $name)
        <span
            class="inline-flex items-center bg-blue-100 dark:bg-blue-900
                   text-blue-800 dark:text-blue-200 px-2 py-1 rounded-full text-xs">
            {{ $name }}
            <button type="button" class="ml-1"
                    wire:click="removeGuest({{ $id }})">&times;</button>
        </span>
        @endforeach
    </div>

    {{-- Modal --}}
    <x-modal wire:model="showModal" title="Add New Guest">
        <div class="space-y-4">
            <x-input label="Full Name" wire:model.live="new_name" />
            <x-input label="Passport #" wire:model.live="new_passport"/>
            <x-input label="Nationality" wire:model.live="new_nationality"/>
            <div class="text-right">
                <x-button variant="primary" wire:click="saveGuest">Save Guest</x-button>
            </div>
        </div>
    </x-modal>

</div>
