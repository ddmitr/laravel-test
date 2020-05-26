<?php

use Illuminate\Database\Seeder;
use App\Match;

class MatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams = App\Team::all();
        $matchweeks = (count($teams) - 1) * 2;
        $matches_per_week = count($teams) / 2; // int
        $all_matches = [];
        $week = 0;
        foreach ($teams as $home) {
            $week++;
            foreach ($teams as $away) {
                if ($home === $away) {
                    continue;
                }
                $week++;
                $all_matches[] = [
                    $home->id,
                    $away->id
                ];
            }
        }

        for ($matchweek = 1; $matchweek <= $matchweeks; $matchweek++) {
            $uniq_team_ids = [];
            for ($i = 0; $i < count($teams) / $matches_per_week; $i++) {
                foreach ($all_matches as $key => $match) {
                    if (!in_array($match[0], $uniq_team_ids) && !in_array($match[1], $uniq_team_ids)) {
                        $uniq_team_ids = array_merge($uniq_team_ids, $match);

                        $goals_home = rand(0, 5);
                        $goals_away = rand(0, 5);
                        $m = Match::create([
                           'home_team_id' => $match[0],
                           'away_team_id' => $match[1],
                            'goals_home' => $goals_home,
                            'goals_away' => $goals_away,
                            'matchweek'  => $matchweek
                        ]);
                        if($goals_home > $goals_away) {
                            $m->winner_id = $match[0];
                            $m->save();
                        } elseif($goals_away > $goals_home) {
                            $m->winner_id = $match[1];
                            $m->save();
                        }
                        unset($all_matches[$key]);
                    }
                }
            }
        }
    }
}
