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
}
