<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MatchResult extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    protected $hidden = ['deleted_at','match_id'];

     public function match()
    {
        return $this->belongsTo(Matches::class);
    }

}
