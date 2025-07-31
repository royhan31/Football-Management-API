<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    protected $hidden = ['deleted_at'];

    public function players()
    {
        return $this->hasMany(Player::class);
    }
}
