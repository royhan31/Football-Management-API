<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\MatchResult;
use Illuminate\Validation\Rule;

class MatchResultController extends Controller
{
    public function index()
    {
        return response()->json(MatchResult::with([
            'match.homeTeam',
            'match.awayTeam',
        ])->get());
    }

    public function show($id)
    {
        try {
            $matches = MatchResult::with([  'match.homeTeam','match.awayTeam'])->findOrFail($id);
            return response()->json($matches, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Match Result not found',
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'home_score' => 'required|integer',
            'away_score' => 'required|integer',
            'match_id' => [
                'required',
                'unique:match_results,match_id',
                Rule::exists('matches', 'id')->whereNull('deleted_at'),
            ],
        ]);

        $matchResult = MatchResult::create($request->all());
        return response()->json($matchResult, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'home_score' => 'required|integer',
            'away_score' => 'required|integer',
            'match_id' => [
                'required',
                'unique:match_results,match_id,'.$id,
                Rule::exists('matches', 'id')->whereNull('deleted_at'),
            ],
        ]);
        
        try {
            $matchResult = MatchResult::findOrFail($id);
            $matchResult->update($request->all());
            return response()->json($matchResult, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Match result not found',
            ], 404);
        }
    }

    public function destroy($id)
    {
         try {
            $matchResult = MatchResult::findOrFail($id);
            $matchResult->delete();
              return response()->json([
                'message' => 'Delete match result success',
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Match result not found',
            ], 404);
        }
       
    }
}
