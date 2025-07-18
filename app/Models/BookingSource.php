<?php

namespace App\Models;

use App\BelongsToTeam;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingSource extends Model
{
    use HasFactory;
    use BelongsToTeam;

    protected $fillable = [
        'team_id', 'name', 'code', 'is_active',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
