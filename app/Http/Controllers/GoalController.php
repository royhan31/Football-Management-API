<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Goal;
use Illuminate\Validation\Rule;

class GoalController extends Controller
{
    public function index()
    {
        return response()->json(Goal::with([
            'player',
            'player.team',
            'match.homeTeam',
            'match.awayTeam',
        ])->get());
    }

    public function show($id)
    {
         try {
            $goal = (Goal::with([
                'player',
                'player.team',
                'match.homeTeam',
                'match.awayTeam',
            ]))->findOrFail($id);

            return response()->json($goal, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Goal not found',
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'goal_time' => 'required',
            'match_id' => [
                'required',
                 Rule::exists('matches', 'id')->whereNull('deleted_at'),
            ],
            'player_id' => [
                'required',
                Rule::exists('players', 'id')->whereNull('deleted_at'),
            ],
        ]);

        $goal = Goal::create($request->all());
        return response()->json($goal, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'goal_time' => 'required',
            'match_id' => [
                'required',
                 Rule::exists('matches', 'id')->whereNull('deleted_at'),
            ],
            'player_id' => [
                'required',
                Rule::exists('players', 'id')->whereNull('deleted_at'),
            ],
        ]);
        
        try {
            $goal = Goal::findOrFail($id);
            $goal->update($request->all());
            return response()->json($goal, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Goal not found',
            ], 404);
        }
    }

     public function destroy($id)
    {
         try {
            $goal = Goal::findOrFail($id);
            $goal->delete();
              return response()->json([
                'message' => 'Delete goal success',
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Goal not found',
            ], 404);
        }
       
    }
}
