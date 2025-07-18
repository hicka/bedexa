<div class="max-w-xl mx-auto">
    <x-page-heading :title="$source ? 'Edit Source' : 'New Booking Source'" />

    <x-card>
        <form wire:submit.prevent="save" class="space-y-4">
            <x-input label="Name"               wire:model.live="name" required />
            <x-input label="Code (slug)"        wire:model.live="code" />
            <x-checkbox label="Active"          wire:model.live="is_active" />

            <div class="flex justify-end gap-2">
                <x-button href="{{ route('sources.index') }}" variant="ghost">Cancel</x-button>
                <x-button variant="primary" type="submit">{{ $source ? 'Update' : 'Create' }}</x-button>
            </div>
        </form>
    </x-card>
</div>
