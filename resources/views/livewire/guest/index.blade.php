<div class="bg-white dark:bg-slate-900 p-6 rounded-xl shadow border border-gray-200 dark:border-slate-700">
    <x-page-heading title="Guests">
        <x-button href="{{ route('guests.create') }}" variant="primary">+ New Guest</x-button>
    </x-page-heading>

    <x-input label="Search" wire:model.live.debounce.300ms="search"
             placeholder="Search name or passport…" class="mb-4" />

    <table class="min-w-full text-sm">
        <thead>
        <tr class="border-b">
            <th>Name</th><th>Passport</th><th>Nationality</th><th class="text-right">Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse($guests as $g)
            <tr class="border-b">
                <td class="py-2">{{ $g->full_name }}</td>
                <td class="py-2">{{ $g->passport_number }}</td>
                <td class="py-2">{{ $g->nationality }}</td>
                <td class="py-2 text-right space-x-2">
                    <x-button size="xs" href="{{ route('guests.edit', $g) }}">Edit</x-button>
                    <x-button size="xs" variant="danger"
                              wire:click="delete({{ $g->id }})">Delete</x-button>
                </td>
            </tr>
        @empty
            <tr><td colspan="4" class="py-6 text-center text-gray-500">No guests found.</td></tr>
        @endforelse
        </tbody>
    </table>

    <div class="mt-4">{{ $guests->links() }}</div>
</div>
