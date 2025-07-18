<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'room_id',
        'check_in',
        'check_out',
        'price',
        'housekeeping_status',
    ];

    protected $casts = [
        'check_in' => 'datetime',
        'check_out' => 'datetime'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function getNightsAttribute()
    {
        return $this->check_in->diffInDays($this->check_out);
    }
    public function getPaymentStateAttribute()
    {
        return $this->booking->balance_due === 0 ? 'paid'
            : ($this->booking->total_paid > 0 ? 'part-paid' : 'unpaid');
    }
}
