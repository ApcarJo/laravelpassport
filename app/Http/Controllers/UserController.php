<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin) {

            $allUsers = User::all();

            return response()->json([
                'success' => true,
                'data' => $allUsers,
            ], 200);

        } else {
            return response()->json([
                'success' => false,
                'message' => 'You have no permissions'
            ], 401);
        }
    }

    /**
     * Display the specified resource by id.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function byId(Request $request)
    {
        // $game = Game::where(Game->gameTitle, $request->gameTitle);
        $user = User::where('id', '=', $request->user_id)->get();
        if (!$user->isEmpty()) {
            return response()->json([
                'success' => true,
                'data' => $user
            ], 200);
        } else {
            return response()->json([
                'success'=>false,
                'message'=>'User not found'
            ], 400);
        }
    }

    /**
     * Display the specified resource by name.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function byName(Request $request)
    {
        // $game = Game::where(Game->gameTitle, $request->gameTitle);
        $user = User::where('userName', '=', $request->userName)->get();
        if (!$user->isEmpty()) {
            return response()->json([
                'success' => true,
                'data' => $user
            ], 200);
        } else {
            return response()->json([
                'success'=>false,
                'message'=>'This user does not exist'
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function showActive(Request $request)
    {
        $allUsers = User::where('isActive', 1)->get();

        return response()->json([
            'success' => true,
            'data' => $allUsers,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Archive the specified resource from storage.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function archive(Request $request)
    {
        $user = auth()->user();

        if ($user->isAdmin) {

            $deactive = User::find($request->user_id);

            if ($deactive) {

                $deactive->isActive = 0;
                $deactive->save();


                return response()->json([
                    'success' => true,
                    'data' => $deactive,
                    'message' => 'Game deleted'
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
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
