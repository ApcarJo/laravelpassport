<?php

namespace App\Http\Controllers;

use App\Models\Party;
use Illuminate\Http\Request;

class PartyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        if ($user) {

            $allparties = Party::all();

            return response()->json([
                'success' => true,
                'data' => $allparties,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'You have no permissions'
            ], 401);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = auth()->user();

        if ($user) {
            $this->validate($request, [
                'partyName' => 'required',
                'game_id' => 'required'
            ]);

            $party = Party::create([
                'partyName' => $request->partyName,
                'game_id' => $request->game_id,
                'owner_id' => $user->id
            ]);

            if ($party) {
                return response()->json([
                    'success' => true,
                    'data' => $party
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Party not added'
                ], 500);
            };
        } else {
            return response()->json([
                'success' => false,
                'message' => 'You need to log in first'
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function showActive()
    {
        $allParties = Party::where('isActive', 1)->get();

        return response()->json([
            'success' => true,
            'data' => $allParties,
        ], 200);
    }

    /**
     * Display the specified resource by name.
     *
     * @param  \App\Models\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function byName(Request $request)
    {
        $party = Party::where('partyName', 'LIKE', '%' . $request->partyName . '%')->get();
        if (!$party->isEmpty()) {
            return response()->json([
                'success' => true,
                'data' => $party
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'This game is not in our library'
            ], 400);
        }
    }

     /**
     * Display the specified resource by name.
     *
     * @param  \App\Models\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function partySelector(Request $request)
    {
        $party = Party::where('partyName', '=', $request->partyName)->get();

        if (!$party->isEmpty()) {
            return response()->json([
                'success' => true,
                'data' => $party
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'This game is not in our library'
            ], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function edit(Party $party)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Party $party)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function destroy(Party $party)
    {
        //
    }
}
