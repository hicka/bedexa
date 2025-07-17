<?php

namespace App;

trait BelongsToTeam
{
    public static function bootBelongsToTeam(): void
    {
        static::creating(function ($model) {
            $model->team_id = $model->team_id ?? auth()->user()?->team_id;
        });

        static::addGlobalScope('team', function ($query) {
            $query->where('team_id', auth()->user()?->team_id);
        });
    }
}
