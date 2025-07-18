<?php

namespace App\Livewire\Booking;

use Livewire\Component;
use App\Models\{Booking,BookingPayment};
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class Payments extends Component
{
    public Booking $booking;

    /* form fields */
    public float  $amount        = 0;
    public string $currency      = 'USD';
    public string $method        = 'cash';
    public ?float $exchange_rate = null;
    public ?string $paid_at      = null;
    public string $notes         = '';

    /* delete confirmation */
    public ?int $confirmDeleteId = null;

    public function rules(): array
    {
        return [
            'amount'        => 'required|numeric|min:0.01',
            'currency'      => ['required','string','size:3'],
            'method'        => Rule::in(['cash','card','bank','ota','online']),
            'exchange_rate' => 'nullable|numeric|min:0',
            'paid_at'       => 'nullable|date',
        ];
    }

    /* ---------- actions ---------- */
    public function savePayment()
    {
        $data = $this->validate();
        $data['paid_at'] ??= Carbon::now();

        // default exchange rate 1:1 if same currency
        if ($data['exchange_rate'] === null && $data['currency'] === 'USD') {
            $data['exchange_rate'] = 1;
        }

        $this->booking->payments()->create($data);
        $this->booking->refreshPaidTotals();

        $this->reset('amount','notes','exchange_rate');
        $this->dispatch('toast', type:'success', message:'Payment recorded.');
    }

    public function confirmDelete($id) { $this->confirmDeleteId = $id; }
    public function cancelDelete()     { $this->confirmDeleteId = null; }

    public function delete()
    {
        $this->booking->payments()->whereKey($this->confirmDeleteId)->delete();
        $this->booking->refreshPaidTotals();
        $this->reset('confirmDeleteId');
        $this->dispatch('toast', type:'success', message:'Payment deleted.');
    }

    /* ---------- render ---------- */
    public function render()
    {
        return view('livewire.booking.payments', [
            'payments' => $this->booking->payments()->latest()->get(),
            'currency' => $this->booking->currency ?? 'USD',
        ]);
    }
}
