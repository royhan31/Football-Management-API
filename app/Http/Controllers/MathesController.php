<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Matches;
use Illuminate\Validation\Rule;

class MathesController extends Controller
{
    public function index()
    {
        return response()->json(Matches::with(['homeTeam', 'awayTeam'])->get());
    }

    public function show($id)
    {
        try {
            $matches = Matches::with(['homeTeam', 'awayTeam'])->findOrFail($id);
            return response()->json($matches, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Matches not found',
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'match_date' => 'required|date|date_format:Y-m-d',
            'match_time' => 'required|date_format:H:i:s',
            'home_team_id' => [
                'required',
                 Rule::exists('teams', 'id')->whereNull('deleted_at'),
            ],
            'away_team_id' => [
                'required',
                'different:home_team_id',
                Rule::exists('teams', 'id')->whereNull('deleted_at'),
            ],
        ]);

        $matches = Matches::create($request->all());
        return response()->json($matches, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'match_date' => 'required|date|date_format:Y-m-d',
            'match_time' => 'required|date_format:H:i:s',
            'home_team_id' => [
                'required',
                 Rule::exists('teams', 'id')->whereNull('deleted_at'),
            ],
            'away_team_id' => [
                'required',
                'different:home_team_id',
                Rule::exists('teams', 'id')->whereNull('deleted_at'),
            ],
        ]);

        try {
            $matches = Matches::findOrFail($id);
            $matches->update($request->all());
            return response()->json($matches, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Matches not found',
            ], 404);
        }
    }

    public function destroy($id)
    {
         try {
            $matches = Matches::findOrFail($id);
            $matches->delete();
              return response()->json([
                'message' => 'Delete matches success',
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'matches not found',
            ], 404);
        }
       
    }
}
