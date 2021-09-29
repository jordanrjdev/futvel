<?php

namespace App\Http\Controllers;

use App\Http\Resources\Team as ResourcesTeam;
use App\Http\Resources\TeamCollection;
use App\Models\Team;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::all();
        return new TeamCollection($teams);
    }

    public function show(Request $request, $id)
    {
        try {
            $team = Team::findOrFail($id);
            return new ResourcesTeam($team);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Team not found'], 404);
        }
    }

    public function store()
    {
        $data = request()->validate([
            'name' => 'required',
        ]);

        $team = Team::create($data);

        return new ResourcesTeam($team);
    }

    public function update($id)
    {
        try {
            $data = request()->validate([
                'name' => 'required',
            ]);
            $team = Team::findOrFail($id);
            $team->update($data);
            return new ResourcesTeam($team);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Team not found'], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $team = Team::findOrFail($id);
            $team->delete();
            return response()->json([], Response::HTTP_NO_CONTENT);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Team not found'], 404);
        }
    }
}
