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
        return $this->belongsToMany(Guest::class);
    }

    public function source()
    {
        return $this->belongsTo(BookingSource::class);
    }

    public function payments()
    {
        return $this->hasMany(BookingPayment::class);
    }
}
