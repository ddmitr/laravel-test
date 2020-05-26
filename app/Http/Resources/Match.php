<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Match extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'home_team' => $this->home_team->name,
            'away_team' => $this->away_team->name,
            'goals_home' => $this->goals_home,
            'goals_away' => $this->goals_away,
        ];
    }
}
