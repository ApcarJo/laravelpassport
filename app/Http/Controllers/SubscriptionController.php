<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Party;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the user descriptions.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        if ($user) {

            $allSubs= Subscription::where('user_id', '=', $user->id)->get();

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
     * Display a listing of the all subscriptions.
     *
     * @return \Illuminate\Http\Response
     */
    public function allsubs()
    {
        $user = auth()->user();

        if ($user->isAdmin) {

            $allSubs= Subscription::all()->groupBy('party_id');

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
     * Create new subscription from user to a party.
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = auth()->user();

        if ($user->id==$request->user_id) {

            $sub = Subscription::where('id', '=', $request->sub_id)->delete();

            if ($sub) {

                return response()->json([
                    'success' => true,
                    'data' => $sub,
                    'message' => 'Party abandoned'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Party not found'
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
