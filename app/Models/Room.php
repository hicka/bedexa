<?php

namespace App\Models;

use App\BelongsToTeam;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use BelongsToTeam;

    protected $fillable = [
        'id',
        'room_number',
        'room_category_id',
        'max_guests',
        'rate',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(RoomCategory::class, 'room_category_id');
    }
}
