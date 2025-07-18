<?php

namespace App\Models;

use App\BelongsToTeam;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    use BelongsToTeam;

    protected $fillable = [
        'team_id',
        'status',
        'adults',
        'children',
        'notes',
        'internal_notes',
        'booking_source_id',
        'room_total','service_charge','tgst','green_tax',
        'discount_amount','tax_inclusive',
        'total_amount','total_paid','balance_due',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function rooms()
    {
        return $this->hasMany(BookingRoom::class);
    }

    public function guests()
    {
        return $this->belongsToMany(Guest::class, 'booking_guest')
            ->withTimestamps();
    }

    public function source()
    {
        return $this->belongsTo(BookingSource::class);
    }

    public function payments()
    {
        return $this->hasMany(BookingPayment::class);
    }

    public function refreshPaidTotals(): void
    {
        $paid = $this->payments()->sum('amount');
        $this->update([
            'total_paid'  => $paid,
            'balance_due' => max($this->total_amount - $paid, 0),
        ]);
    }
}
