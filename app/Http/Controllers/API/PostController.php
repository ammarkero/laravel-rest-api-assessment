<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showImage(Post $post)
    {
        return response()->json([
            'data' => [
                'image_path' => $post->image->image_path
            ],
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeImage(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'image_path' => 'required|max:255',
        ]);

        $image = $post->image()->create($validatedData);

        return new PostResource($post);
    }
}
