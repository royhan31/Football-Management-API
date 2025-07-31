<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Team;

class TeamController extends Controller
{
    public function index()
    {
        return response()->json(Team::all());
    }

    public function show($id)
    {
        try {
            $team = Team::with('players')->findOrFail($id);
            return response()->json($team);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Team not found',
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'founded_year' => 'required|digits:4|integer',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $requestData = $request->all();

         if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('images', 'public');
            $requestData['logo'] = asset('storage/' . $path);
         }

        $team = Team::create($requestData);
        return response()->json($team, 201);
    }

    public function update(Request $request, $id)
    { 
        $request->validate([
            'name' => 'required|string|max:255',
            'founded_year' => 'required|digits:4|integer',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $team =  Team::findOrFail($id);
            $requestData = $request->all();

            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->store('images', 'public');
                $requestData['logo'] = asset('storage/' . $path);
            }

            $team->update($requestData);
            return response()->json($team);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Team not found',
            ], 404);
        }
        
    }

    public function destroy($id)
    {
         try {
            $team =  Team::findOrFail($id);
            $team->delete();
            return response()->json([
                'message' => 'Delete team success',
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Team not found',
            ], 404);
        }
       
    }
}
