<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return Post::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
    $post = $request->user()->posts()->create($request->validated());
    return response()->json($post, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
    return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     */
public function update(UpdatePostRequest $request, Post $post)
{
    if ($request->user()->id !== $post->user_id) {
        return response()->json([
            'message' => 'Unauthorized'
        ], 403);
    }

    $fields = $request->validated();

    $post->update($fields);

    return response()->json([
        'post' => $post
    ]);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, Request $request)
    {
    if ($request->user()->id !== $post->user_id) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully'
        ]);
    }
}
