<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = auth()->user()->posts;

        return response()->json([
            'success' => true,
            'data' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required'
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;

        if (auth()->user()->posts()->save($post))
        return response()->json([
            'success' => true,
            'data' => $post->toArray()
        ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Post not added'
            ], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = auth()->user()->posts()->find($id);

        if (!post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $post->toArray()
        ], 400);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = auth()->user()->posts()->find($id);

        if(!post) {
            return response()->json ([
                'success' => false,
                'message' => 'Post not found'
            ], 400);
        }

        $updated = $post->fill($request->all())->save();

        if (!updated)
        return response()->json([
            'success' => true
        ]);
        else
            return response()->json([
                'sucess' => false,
                'message' => 'Post can not be updated'
            ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post = auth()->user()->posts()->find($id);

        if(!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 400);
        }

        if(!$post->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post can not be deleted'
            ], 500);
        }
    }
}
