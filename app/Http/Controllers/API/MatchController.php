<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Match;
use App\Team;
use Illuminate\Http\Request;
use App\Http\Resources\Match as MatchResource;

class MatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $total_points = 0;
        $table = [];
        $teams = Team::all();
        $matchweek = $request->get('matchweek');
        $weekly = Match::where('matchweek', '=', $matchweek)->get();
        foreach ($teams as $team) {
            $won = Match::where('matchweek', '<=', $matchweek)->where('winner_id', $team->id)->count();
            $drawn = Match::where('matchweek', '<=', $matchweek)->whereNull('winner_id')
                ->where(function ($q) use ($team) {
                    return $q
                        ->where('home_team_id', $team->id)
                        ->orWhere('away_team_id', $team->id);
                })->count();
            $lost = Match::where('matchweek', '<=', $matchweek)->where('winner_id', '<>', $team->id)
                ->where(function ($q) use ($team) {
                    return $q
                        ->where('home_team_id', $team->id)
                        ->orWhere('away_team_id', $team->id);
                })->count();
            $table[] = [
                'team' => $team->name,
                'played' => $matchweek,
                'won' => $won,
                'drawn' => $drawn,
                'lost' => $lost,
                'points' => $won * 3 + $drawn,
                'pred' => 10 // TODO:
            ];
        }
        usort($table, function ($a, $b) {
            return $a['points'] < $b['points'];
        });

        return response()->json(
            [
                'table' => $table,
                'matches' => MatchResource::collection($weekly),
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Match $match
     * @return \Illuminate\Http\Response
     */
    public function show(Match $match)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Match $match
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Match $match)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Match $match
     * @return \Illuminate\Http\Response
     */
    public function destroy(Match $match)
    {
        //
    }
}
