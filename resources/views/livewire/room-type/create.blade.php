<div class="max-w-2xl mx-auto">
    <x-page-heading :title="$roomTypeId ? 'Edit Room Type' : 'New Room Type'" />

    <x-card>
        <form wire:submit.prevent="save" class="space-y-4">
            <x-input label="Name" wire:model.defer="name" required />
            <x-input label="Base Price" wire:model.defer="base_price" type="number" min="0" step="0.01" required />
            <x-textarea label="Description" wire:model.defer="description" />

            <div class="flex justify-between">
                <x-button type="submit" variant="primary">
                    {{ $roomTypeId ? 'Update' : 'Create' }}
                </x-button>
                <x-button href="{{ route('room-types.index') }}" variant="ghost">Cancel</x-button>
            </div>
        </form>
    </x-card>
</div>
