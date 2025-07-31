<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Goal extends Model
{
    use HasFactory, SoftDeletes;

     protected $guarded = [];

    protected $hidden = ['match_id','player_id','deleted_at'];

    public function player()
    {
        return $this->belongsTo(Player::class, 'player_id');
    }

     public function match()
    {
        return $this->belongsTo(Matches::class, 'match_id');
    }
}
