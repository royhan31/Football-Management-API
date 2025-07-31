<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Player;
use Illuminate\Validation\Rule;

class PlayerController extends Controller
{
    public function index()
    {
        return response()->json(Player::all());
    }

    public function show($id)
    {
        try {
            $player = Player::with('team')->findOrFail($id);
            return response()->json($player);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'player not found',
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'team_id' => [
                'required',
                 Rule::exists('teams', 'id')->whereNull('deleted_at'),
            ],
            'number' => 'required|integer',
            'position' => 'in:penyerang,gelandang,bertahan,penjaga gawang',
            'number' => 'unique:players,number,NULL,id,team_id,' . $request->team_id,
        ]);

        $player = Player::create($request->all());
        return response()->json($player, 201);
    }

    public function update(Request $request, $id)
    {
          $request->validate([
            'name' => 'required|string|max:255',
            'team_id' => [
                'required',
                 Rule::exists('teams', 'id')->whereNull('deleted_at'),
            ],
            'number' => 'required|integer',
            'position' => 'in:penyerang,gelandang,bertahan,penjaga gawang',
             'number' => [
                'required',
                'integer',
                Rule::unique('players')->where(function ($query) use ($request) {
                    return $query->where('team_id', $request->team_id);
                })->ignore($id),
            ],
        ]);

         try {
            $player = Player::findOrFail($id);
            $player->update($request->all());
            return response()->json($player);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'player not found',
            ], 404);
        }
       
    }

    public function destroy($id)
    {
         try {
            $player = Player::findOrFail($id);
            $player->delete();
              return response()->json([
                'message' => 'Delete player success',
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'player not found',
            ], 404);
        }
       
    }
}
