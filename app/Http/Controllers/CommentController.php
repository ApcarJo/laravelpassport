<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
                'message' => 'required',
                'party_id' => 'required'
            ]);

            $comment = Comment::create([
                'message' => $request->message,
                'party_id' => $request->party_id,
                'user_id' => $user->id
            ]);

            if ($comment) {
                return response()->json([
                    'success' => true,
                    'data' => $comment
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
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        if ($user->isAdmin) {

            $comment = Comment::find($request->comment_id);

            if ($comment) {

                $update = $comment->fill($request->all())->save();

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
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = auth()->user();

        if ($user->id==$request->user_id) {

            $comment = Comment::where('id', '=', $request->comment_id)->where('party_id', '=', $request->party_id)->delete();

            if ($comment) {

                return response()->json([
                    'success' => true,
                    'data' => $comment,
                    'message' => 'Message deleted'
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
