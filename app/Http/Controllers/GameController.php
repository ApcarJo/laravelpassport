<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allGames = Game::all();

        return response()->json([
            'success' => true,
            'data' => $allGames,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // $user = auth()->user();

        // if ($user->isAdmin==true) {

        $this->validate($request, [
            'gameTitle' => 'required',
            'thumbnail_url' => 'required',
            'url' => 'required'

        ]);

        $game = Game::create([
            'gameTitle' => $request->gameTitle,
            'thumbnail_url' => $request->thumbnail_url,
            'url' => $request->url
        ]);

        if ($game) {
            return response()->json([
                'success' => true,
                'data' => $game
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Game not added'
            ], 500);
        };
        // }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // $game = Game::where(Game->gameTitle, $request->gameTitle);
        $game = Game::where('gameTitle', '=', $request->gameTitle)->get();
        if (!$game->isEmpty()) {
            return response()->json([
                'success' => true,
                'data' => $game
            ], 200);
        } else {
            return response()->json([
                'success'=>false,
                'message'=>'This game is not in our library'
            ], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function edit(Game $game)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Game $game)
    {
        $user = auth()->user();

        if ($user->isAdmin) {

            $game = Game::find($request->id);

            if ($game) {

                $update = $game->fill($request->all())->save();

                if ($update) {
                    return response()->json([
                        'success' => true
                    ], 200);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Game not updated'
                    ], 400);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Game not found'
                ], 400);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = auth()->user();

        if ($user->isAdmin) {

            $game = Game::find($request->game_id);

            if ($game) {

                $game->update([
                    'isActive' => false
                ]);

                return response()->json([
                    'success' => true,
                    'data' => $game,
                    'message' => 'Game archived'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Game not found'
                ], 500);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => "You don't have permissions"
            ], 400);
        }
    }
}
