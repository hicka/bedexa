<div class="bg-white dark:bg-slate-900 p-6 rounded-xl shadow border border-gray-200 dark:border-slate-700">
    <x-page-heading title="Booking Sources">
        <x-button href="{{ route('sources.create') }}" variant="primary">+ New Source</x-button>
    </x-page-heading>

    <x-input label="Search" wire:model.live.debounce.300ms="search" placeholder="Search…" class="mb-4"/>

    <table class="min-w-full text-sm">
        <thead><tr class="border-b"><th>Name</th><th>Code</th><th>Status</th><th class="text-right">Actions</th></tr></thead>
        <tbody>
        @forelse($sources as $src)
            <tr class="border-b">
                <td class="py-2">{{ $src->name }}</td>
                <td class="py-2">{{ $src->code }}</td>
                <td class="py-2">
                    <span class="px-2 py-1 text-xs rounded-full {{ $src->is_active?'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300':'bg-gray-200 text-gray-600 dark:bg-slate-700 dark:text-gray-400' }}">
                        {{ $src->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="py-2 text-right space-x-2">
                    <x-button size="xs" href="{{ route('sources.edit',$src) }}">Edit</x-button>
                    <x-button size="xs" variant="outline" wire:click="toggle({{ $src->id }})">
                        {{ $src->is_active ? 'Disable' : 'Enable' }}
                    </x-button>
                    <x-button size="xs" variant="danger" wire:click="delete({{ $src->id }})">Delete</x-button>
                </td>
            </tr>
        @empty
            <tr><td colspan="4" class="py-6 text-center text-gray-500">No sources found.</td></tr>
        @endforelse
        </tbody>
    </table>

    <div class="mt-4">{{ $sources->links() }}</div>
</div>
