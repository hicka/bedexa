<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $guarded = [];

    public function guests()
    {
        return $this->belongsToMany(Guest::class, 'booking_guest')
            ->withPivot('is_primary')
            ->withTimestamps();
    }
}
