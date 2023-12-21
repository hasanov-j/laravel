<?php

namespace App\Http\Controllers\Mobile\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\Api\PostStoreRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    public function index()
    {
        return Post::all();
    }

    public function store(PostStoreRequest $request)
    {
        $user = User::get()->random();


//        $result=Post::create(
//            [
//                'title'=>$request->get('title'),
//                'description'=>$request->get('description'),
//                'user_id'=>$user->id,
//            ]
//        );

        return response()->json(data: $user->posts()->create($request->validated()),status: Response::HTTP_CREATED);
    }

    public function show(Post $post)
    {
        return $post;
    }

    public function update(Request $request, Post $post)
    {
        $post->update([$request->validated()]);

        return \response()->json($post);
    }


    public function destroy(Post $post)
    {
        $post->delete();
    }
}
