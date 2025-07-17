<?php

namespace App\Models;

use App\BelongsToTeam;
use Illuminate\Database\Eloquent\Model;

class RoomCategory extends Model
{
    use BelongsToTeam;

    protected $fillable = [
        'id',
        'team_id',
        'name',
        'description',
        'default_rate',
    ];
}
