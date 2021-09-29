<?php

namespace App\Http\Controllers;

use App\Http\Resources\League as ResourcesLeague;
use App\Http\Resources\LeagueCollection;
use App\Models\League;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LeagueController extends Controller
{
    public function index()
    {
        $leagues = League::all();
        return new LeagueCollection($leagues);
    }

    public function show($id)
    {
        try {
            $league = League::findOrFail($id);
            return new ResourcesLeague($league);
        } catch (ModelNotFoundException $e) {
            return response()->json(['Error' => 'League not found'], 404);
        }
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'number_dates' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $league = League::create($data);

        return new ResourcesLeague($league);
    }

    public function update($id)
    {
        try {
            $data = request()->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'number_dates' => 'required|integer',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
            ]);

            $league = League::find($id);

            $league->update($data);

            return new ResourcesLeague($league);
        } catch (ModelNotFoundException $e) {
            return response()->json(['Error' => 'League not found'], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $league = League::findOrFail($id);
            $league->delete();
            return response()->json([], Response::HTTP_NO_CONTENT);
        } catch (ModelNotFoundException $e) {
            return response()->json(['Error' => 'League not found'], 404);
        }
    }
}
