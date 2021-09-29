<?php

namespace App\Http\Controllers;

use App\Http\Resources\Player as ResourcesPlayer;
use App\Http\Resources\PlayerCollection;
use App\Models\Player;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new PlayerCollection(Player::all());
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'position' => 'required|string|max:255',
                'team_id' => 'required|integer',
            ]);
            $player = Player::create($data);
            return new ResourcesPlayer($player);
        } catch (\Exception$e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $player = Player::findOrFail($id);
            return new ResourcesPlayer($player);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Player not found'], 404);
        }
    }

    public function update($id)
    {
        try {
            $data = request()->validate([
                'name' => 'required|string|max:255',
                'position' => 'required|string|max:255',
            ]);
            $player = Player::findOrFail($id);
            $player->update($data);
            return new ResourcesPlayer($player);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Player not found'], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $player = Player::findOrFail($id);
            $player->delete();
            return response()->json([], Response::HTTP_NO_CONTENT);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Player not found'], 404);
        }
    }
}
