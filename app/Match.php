<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    /**
     *
     * @var array
     */
    protected $fillable = [
        'home_team_id',
        'away_team_id',
        'goals_home',
        'goals_away',
        'winner_id',
        'matchweek'
    ];


    /**
     * Get the home team.
     */
    public function home_team()
    {
        return $this->belongsTo('App\Team');
    }

    /**
     * Get the away team.
     */
    public function away_team()
    {
        return $this->belongsTo('App\Team');
    }

    /**
     * Get the winner.
     */
    public function winner()
    {
        return $this->belongsTo('App\Team');
    }
}
