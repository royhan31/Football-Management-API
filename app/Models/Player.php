<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];

    protected $hidden = ['team_id', 'deleted_at'];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
