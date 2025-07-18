<?php

namespace App\Models;

use App\BelongsToTeam;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;
    use BelongsToTeam;

    protected $fillable = [
        'team_id',
        'full_name',
        'passport_number',
        'identity_card',
        'nationality',
        'gender',
        'date_of_birth',
        'phone',
        'email',
        'address',
        'type',
        'photo_path',
        'notes',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_guest')
            ->withTimestamps();
    }
}
