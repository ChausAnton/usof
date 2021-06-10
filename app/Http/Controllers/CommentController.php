<?php

namespace App\Http\Controllers;

//include '/Users/anchaus/Desktop/usoft/app/Support/helpers.php';
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index()
    {
        //get Comments
        if(isAdmin(auth()->user())) 
            return Comment::all();
        return getOnlyAtiveComments(NULL);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validated =  $request->validate([
            'post_id'=> 'required',
            'content'=> 'required|string'
        ]);
        if(auth()->user()) {
            $data = [
                'author' => auth()->user()->login,
                'user_id' => auth()->user()->id,
                'post_id' => $validated ['post_id'],
                'content' => $validated ['content'],
                'rating' => 0,
                'status' => 'active'
            ];
            return Comment::create($data);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //show Comment
        if(isAdmin(auth()->user())) 
            return Comment::find($id);
        return getOnlyAtiveComments($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //update Comment
        $Comment = Comment::find($id);
        if(!isAdmin(auth()->user()) && !isUser(JWTAuth::getToken(), getUserByLogin($Comment->author)->id)) {
            return "only admin and author can change comment's data";
        }

        if(isAdmin(auth()->user())) {
            if(isset($request['status'])) {
                $Comment->status = $request['status'];
                $Comment->save();
            }
           return $Comment;
        }
        if(isset($request['content'])) {
            $Comment->content = $request['content'];
            $Comment->save();
        }
        return $Comment;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Comment::find($id);
        if(!isAdmin(auth()->user()) && !isUser(JWTAuth::getToken(), $post->user_id)) {
            return "only admin and author can delete comment";
        }
        return Comment::destroy($id);
        //delete Comment
        
    }
}
