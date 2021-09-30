<?php

namespace App\Http\Controllers;

use App\Http\Resources\League as ResourcesLeague;
use App\Http\Resources\LeagueCollection;
use App\Imports\TeamImport;
use App\Models\League;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;

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
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'number_dates' => 'required|integer',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'teams' => 'required|array|min:1',
            ]);

            $league = League::create([
                'name' => $request->name,
                'description' => $request->description,
                'number_dates' => $request->number_dates,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);

            foreach ($request->teams as $team) {
                $league->teams()->attach($team);
            }

            return new ResourcesLeague($league);
        } catch (\Exception$e) {
            return response()->json(['Error' => $e->getMessage()], 400);
        }
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

    public function import(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|file|mimes:xlsx,xls',
            ]);

            $file = $request->file('file');
            Excel::import(new TeamImport, $file);
            return response()->json(['Success' => 'Teams imported successfully'], 200);
        } catch (\Exception$e) {
            return response()->json(['Error' => $e->getMessage()], 400);
        }
    }
}
