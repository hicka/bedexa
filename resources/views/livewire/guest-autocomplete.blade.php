<div class="space-y-4">
    <x-input
        label="Search Guest"
        wire:model.live.debounce.300ms="search"
        placeholder="Search by name or passport"
    />

    @if ($results)
        <ul class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-slate-900 shadow-sm divide-y divide-neutral-100 dark:divide-slate-800">
            @forelse ($results as $guest)
                <li
                    wire:click="selectGuest({{ $guest->id }})"
                    class="px-4 py-2 cursor-pointer hover:bg-neutral-50 dark:hover:bg-slate-800 transition"
                >
                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                        {{ $guest->full_name }}
                    </div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">
                        {{ $guest->passport_number }}
                    </div>
                </li>
            @empty
                <li class="px-4 py-2 text-sm text-gray-500 dark:text-gray-400">
                    No results.
                    <a
                        wire:click="$dispatch('openNewGuestModal').toParent()"
                        class="underline text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 cursor-pointer"
                    >
                        Add new guest
                    </a>
                </li>
            @endforelse
        </ul>
    @endif

    @if (!empty($selectedGuests))
        <div class="flex flex-wrap gap-2">
            @foreach ($selectedGuests as $guest)
                <span class="inline-flex items-center rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-300 px-3 py-1 text-xs font-medium">
                    {{ $guest['name'] }}
                    <button
                        type="button"
                        wire:click="removeGuest({{ $guest['id'] }})"
                        class="ml-2 text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300"
                        title="Remove"
                    >
                        ×
                    </button>
                </span>
            @endforeach
        </div>
    @endif
</div>
