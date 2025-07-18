<?php

namespace App\Models;

use App\BelongsToTeam;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;
    use BelongsToTeam;

    protected $fillable = ['team_id', 'name', 'description', 'base_price'];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
