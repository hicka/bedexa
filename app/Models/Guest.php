<?php

namespace App\Models;

use App\BelongsToTeam;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use BelongsToTeam;

    protected $fillable = [
        'id',
        'team_id',
        'full_name',
        'email',
        'phone',
        'nationality',
        'passport_number',
        'address',
        'notes',
    ];

    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_guest')
            ->withPivot('is_primary')
            ->withTimestamps();
    }
}
