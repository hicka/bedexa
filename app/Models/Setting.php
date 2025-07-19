<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['team_id','key','value'];
    protected $casts    = ['value'=>'json'];

    /* quick helper */
    public static function value(string $key, $default = null)
    {
        $row = cache()->remember(
            auth()->user()->team_id.'_'.$key,
            now()->addDay(),
            fn() => static::where('team_id', auth()->user()->team_id)
                ->where('key',$key)->first()
        );
        return $row->value ?? $default;
    }
}
