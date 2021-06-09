<?php

namespace App\Http\Controllers;

include '/Users/antoncaus/Desktop/usoft/app/Support/helpers.php';
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
            $like = DB::select("select * from likes where user_id = $request->user_id and post_id = $request->post_id;");
            if(!$like)
                return Like::create($request->all());
            elseif($like && strcmp($like[0]->type, $request['type']) != 0) {
                DB::delete("delete from likes where user_id = $request->user_id and post_id = $request->post_id;");
                return Like::create($request->all());
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
