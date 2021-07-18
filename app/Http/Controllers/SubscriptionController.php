<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Party;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user) {

            $allSubs= Subscription::where('user_id', '=', $request->user_id);

            return response()->json([
                'success' => true,
                'data' => $allSubs,
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

        $duplicate = Subscription::where('user_id', "=", $request->user_id)->where('party_id', '=', $request->party_id)->get();

        if ((($user->isAdmin)||($user->id==$request->user_id))&&($duplicate->isEmpty())) {
            $this->validate($request, [
                'party_id' => 'required',
                'user_id' => 'required'
            ]);

            $subscription = Subscription::create([
                'party_id' => $request->party_id,
                'user_id' => $request->user_id
            ]);

            if ($subscription) {
                return response()->json([
                    'success' => true,
                    'data' => $subscription
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot join to the party'
                ], 500);
            };
        } else {
            return response()->json([
                'success' => false,
                'message' => 'You need to log in first or you are already in the party'
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
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function show(Subscription $subscription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscription $subscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscription $subscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscription $subscription)
    {
        //
    }
}
