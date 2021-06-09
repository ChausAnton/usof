<?php

namespace App\Http\Controllers;

include '/Users/antoncaus/Desktop/usoft/app/Support/helpers.php';
include '/Users/antoncaus/Desktop/usoft/app/Http/Controllers/CategorySubTableController.php';
use Illuminate\Http\Request;
use App\Models\Post;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;

class PostsController extends Controller
{
    public function index()
    {
        //get Posts
        return Post::all();
    }

    
    public function store(Request $request)
    {
        if(!auth()->user()) {
            return "only logged users can create posts";
        }

        $data = [
            'author' => $request->input('author'),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'likes' => $request->input('likes'),
        ];

        $post = Post::create($data);
        $CategorySub = New CategorySubTableController();
        $CategorySub->addCategory($request['category_id'], $post->id);
        return $post;
    }


    public function show($id)
    {
        //show Post
        return Post::find($id);
    }

    
    public function update(Request $request, $id)
    {
        //update Post
        $Post = Post::find($id);
        $Post->update($request->all());
        return $Post;
    }


    public function destroy($id)
    {
        $post = Post::find($id);
        if(!isAdmin(auth()->user()) && !isUser(JWTAuth::getToken(), getUserByLogin($post->author)->id)) {
            return "only admin and author can delete post";
        }
        return Post::destroy($id);
        //delete Post
        
    }
}
