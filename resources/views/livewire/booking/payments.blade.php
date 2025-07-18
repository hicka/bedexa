<div class="space-y-8">

    {{-- ─── Summary Card ─────────────────────────────── --}}
    <x-card>
        @php
            $paid   = $booking->total_paid;
            $due    = $booking->balance_due;
            $total  = $booking->total_amount;
            $pct    = $total > 0 ? min(100, round($paid / $total * 100)) : 0;
        @endphp

        <header class="mb-4 flex justify-between items-center">
            <h3 class="font-semibold text-lg">Balance</h3>
            <span class="text-sm text-gray-500">{{ $booking->currency ?? 'USD' }}</span>
        </header>

        {{-- progress bar --}}
        <div class="w-full h-3 rounded-full bg-gray-200 dark:bg-slate-700 overflow-hidden mb-3">
            <div
                class="h-full rounded-full transition-all duration-300
                       {{ $due > 0 ? 'bg-yellow-500' : 'bg-green-500' }}"
                style="width: {{ $pct }}%">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-2 text-sm">
            <div>Total:</div> <div class="text-right font-medium">{{ number_format($total,2) }}</div>
            <div>Paid:</div>  <div class="text-right">{{ number_format($paid,2) }}</div>
            <div>Balance:</div>
            <div class="text-right {{ $due>0?'text-red-600 dark:text-red-400':'text-green-600' }}">
                {{ number_format($due,2) }}
            </div>
        </div>
    </x-card>

    {{-- ─── New Payment Form ─────────────────────────── --}}
    <x-card>
        <header class="font-semibold mb-4">Add Payment</header>

        <form wire:submit.prevent="savePayment" class="grid md:grid-cols-4 gap-4 items-end">
            <x-input label="Amount" type="number" step="0.01" wire:model.live="amount" />

            <x-select label="Currency" wire:model.live="currency">
                <option value="USD">USD</option>
                <option value="MVR">MVR</option>
            </x-select>

            <x-select label="Method" wire:model.live="method">
                <option value="cash">Cash</option>
                <option value="card">Card</option>
                <option value="bank">Bank</option>
                <option value="ota">OTA Payout</option>
                <option value="online">Online</option>
            </x-select>

            {{-- exchange rate shown only when currency ≠ booking currency --}}
            @if($currency !== ($booking->currency ?? 'USD'))
                <x-input label="Exchange Rate" type="number" step="0.0001" min="0"
                         wire:model.live="exchange_rate" />
            @endif

            <x-input label="Paid at" type="datetime-local" wire:model.live="paid_at" />

            <x-input label="Notes" wire:model.live="notes" class="md:col-span-3" />

            <x-button variant="primary" type="submit" class="md:col-span-1">
                Add
            </x-button>
        </form>
    </x-card>

    {{-- ─── Payments Table ───────────────────────────── --}}
    <x-card>
        <x-slot name="header">Payment History</x-slot>

        <table class="min-w-full text-sm">
            <thead>
            <tr class="border-b">
                <th>Date</th><th>Amount</th><th>Method</th><th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($payments as $p)
                <tr class="border-b">
                    <td>{{ $p->paid_at->format('Y-m-d H:i') }}</td>
                    <td>{{ number_format($p->amount,2) }} {{ $p->currency }}</td>
                    <td>{{ ucfirst($p->method) }}</td>
                    <td class="text-right">
                        <x-button size="xs" variant="danger"
                                  wire:click="confirmDelete({{ $p->id }})">
                            Delete
                        </x-button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="py-4 text-center text-gray-500">No payments yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </x-card>

    {{-- ─── Delete Confirmation Modal ───────────────── --}}
    <x-modal wire:model="confirmDeleteId" title="Delete Payment?">
        <p class="text-sm mb-4">This payment will be permanently removed.</p>
        <div class="flex justify-end gap-2">
            <x-button variant="ghost" wire:click="cancelDelete">Cancel</x-button>
            <x-button variant="danger" wire:click="delete">Delete</x-button>
        </div>
    </x-modal>

</div>
