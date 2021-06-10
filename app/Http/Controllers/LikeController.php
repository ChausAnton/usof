<?php

namespace App\Http\Controllers;

//include '/Users/anchaus/Desktop/usoft/app/Support/helpers.php';
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use App\Models\Like;
use DB;

class LikeController extends Controller
{
    public function index()
    {
        //get Likes
        return Like::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(auth()->user()) {//likes
            if($request->post_id)
                $like = DB::select("select * from likes where user_id = " . auth()->user()->id . " and post_id = $request->post_id;");
            else
                $like = DB::select("select * from likes where user_id = " . auth()->user()->id . " and comment_id = $request->comment_id;");
            if(!$like) {
                $data = [
                    'author' => auth()->user()->login,
                    'user_id' => auth()->user()->id,
                    'post_id' => $request->input('post_id'),
                    'comment_id' => $request->input('comment_id'),
                    'content' => $request->input('content'),
                    'type' => $request->input('type'),
                    'status' => 'active'
                ];
                
                return Like::create($data);
            }
            elseif($like && strcmp($like[0]->type, $request['type']) != 0) {
                if($request->post_id)
                    DB::delete("delete from likes where user_id = " . auth()->user()->id . " and post_id = $request->post_id;");
                else 
                    DB::delete("delete from likes where user_id = " . auth()->user()->id . " and comment_id = $request->comment_id;");
                $data = [
                    'author' => auth()->user()->login,
                    'user_id' => auth()->user()->id,
                    'post_id' => $request->input('post_id'),
                    'comment_id' => $request->input('comment_id'),
                    'content' => $request->input('content'),
                    'type' => $request->input('type'),
                    'status' => 'active'
                ];
                return Like::create($data);
            }
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
        //show Like
        return Like::find($id);
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
        //update Like
        $Like = Like::find($id);
        $Like->update($request->all());
        return $Like;
    }// to delete

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Like::destroy($id);
        //delete Like
        
    }// to delete
}
