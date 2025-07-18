<div class="max-w-2xl mx-auto">
    <x-page-heading :title="$guest ? 'Edit Guest' : 'New Guest'" />

    <x-card>
        <form wire:submit.prevent="save" class="space-y-4">

            <div class="grid md:grid-cols-2 gap-4">
                <x-input label="Full Name" wire:model.live="full_name" required />
                <x-input label="Passport #" wire:model.live="passport_number" />
                <x-input label="Nationality" wire:model.live="nationality" required />
                <x-select label="Type" wire:model.live="type">
                    <option value="foreign">Foreign</option>
                    <option value="local">Local</option>
                </x-select>
                <x-input label="Phone" wire:model.live="phone" />
                <x-input label="ID Card (locals)" wire:model.live="id_card" />
                <x-input type="date" label="Date of Birth" wire:model.live="dob" />
                <x-select label="Gender" wire:model.live="gender">
                    <option value="">—</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </x-select>
            </div>

            <x-textarea label="Address" wire:model.live="address" />
            <x-textarea label="Notes" wire:model.live="notes" />

            <div class="flex justify-end gap-2">
                <x-button href="{{ route('guests.index') }}" variant="ghost">Cancel</x-button>
                <x-button variant="primary" type="submit">{{ $guest ? 'Update' : 'Create' }}</x-button>
            </div>
        </form>
    </x-card>
</div>
