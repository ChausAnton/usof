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
        if(isAdmin(auth()->user()))
            return Post::all();

        return getOnlyAtivePosts(NULL);
        
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
            'status' => $request->input('status')
        ];

        $post = Post::create($data);
        $CategorySub = New CategorySubTableController();
        $CategorySub->addCategory($request['category_id'], $post->id);
        return $post;
    }


    public function show($id)
    {
        //show Post
        if(isAdmin(auth()->user()))
            return Post::find($id);
        return getOnlyAtivePosts($id);
    }   

    
    public function update(Request $request, $id)
    {
        //update Post
        $post = Post::find($id);
        if(!isAdmin(auth()->user()) && !isUser(JWTAuth::getToken(), getUserByLogin($post->author)->id)) {
            return "only admin and author of post can change post's data";
        }

        if(isset($request['category_id'])) {
            $CategorySub = New CategorySubTableController();
            $CategorySub->addCategory($request['category_id'], $post->id);
        }

        if(isAdmin(auth()->user())) {
            $Post = Post::find($id);
            if(isset($request['status'])) {
                $Post->status = $request['status'];
                $Post->save();
            }
           return $Post;
        }

        $Post = Post::find($id);

        $data = [
            'title' => ($request->input('title') ? $request->input('title') : $Post->title),
            'content' => ($request->input('content') ? $request->input('content') : $Post->content),
        ];
        
        $Post->update($data);
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
