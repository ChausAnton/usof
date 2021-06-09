<?php

namespace App\Http\Controllers;

//include '/Users/antoncaus/Desktop/usoft/app/Http/Controllers/CategorySubTableController.php';
include '/Users/antoncaus/Desktop/usoft/app/Support/helpers.php';
use Illuminate\Http\Request;
use App\Models\Post;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use DB;

//////////////////////
function getPostsWithCategory($all) {
    $CategorySub = New CategorySubTableController();
    if($all) {
        $postData = Post::all();
        foreach($postData as $post) {
            $post->categories = $CategorySub->getCategoriesForPost($post->id);
        }
        return $postData;
    }
    $postData = getOnlyAtivePosts(NULL);
    foreach($postData as $post) {
        $post->categories = $CategorySub->getCategoriesForPost($post->id);
    }
    return $postData;
    
}// move to helpers

function getOnePostWithCategory($admin, $id) {
    $CategorySub = New CategorySubTableController();
    if($admin) {
        $postData = DB::select("select * from posts where id = $id;");;
        if($postData)
            $postData[0]->categories = $CategorySub->getCategoriesForPost($id);
        return $postData;
    }
    $postData = getOnlyAtivePosts($id);
    if($postData)
        $postData[0]->categories = $CategorySub->getCategoriesForPost($id);
    return $postData;
}// move to helpers
/////////////////////////

class PostsController extends Controller
{
    public function index()
    {
        //get Posts
        if(isAdmin(auth()->user())) {
            return getPostsWithCategory(true);
        }

        return getPostsWithCategory(false);
        
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
            return getOnePostWithCategory(true, $id);
        return getOnePostWithCategory(false, $id);
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
