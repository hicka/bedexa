<div>
    @if ($open)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
            <div class="bg-white dark:bg-slate-900 w-full max-w-xl p-6 rounded-lg shadow-xl">
                <h2 class="text-lg font-bold mb-4">Add New Guest</h2>
                <form wire:submit.prevent="save" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-input label="Full Name" wire:model.defer="full_name" required />
                    <x-input label="Email" wire:model.defer="email" type="email" />
                    <x-input label="Phone" wire:model.defer="phone" />
                    <x-input label="Nationality" wire:model.defer="nationality" />
                    <x-input label="Passport Number" wire:model.defer="passport_number" />
                    <x-textarea label="Address" wire:model.defer="address" class="md:col-span-2" />
                    <x-textarea label="Notes" wire:model.defer="notes" class="md:col-span-2" />
                    <div class="col-span-full flex justify-end gap-2 mt-4">
                        <x-button type="button" variant="ghost" wire:click="$set('open', false)">Cancel</x-button>
                        <x-button type="submit" variant="primary">Save</x-button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>
