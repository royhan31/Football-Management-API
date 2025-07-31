<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Matches extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    protected $hidden = ['deleted_at','home_team_id','away_team_id'];

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    public function result()
    {
        return $this->hasOne(MatchResult::class, 'match_id');
    }

    public function goals()
    {
        return $this->hasMany(Goal::class, 'match_id');
    }

}
