<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategorySubTabel;

class CategorySubTableController extends Controller
{
    public function index()
    {
        //get CategorySubTabel
        return CategorySubTabel::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        return CategorySubTabel::create($request->all());
    }

    public function addCategory($CategoryJson, $postID)
    {
        DB::delete("delete from category_sub where post_id = $postID;");
        foreach($CategoryJson as $cat) {
            $data = [
                'post_id' => $postID,
                'category_id' => $cat
            ];
            CategorySubTabel::create($data);
        }
        return true;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //show CategorySubTabel
        return CategorySubTabel::find($id);
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
        //update CategorySubTabel
        $CategorySubTabel = CategorySubTabel::find($id);
        $CategorySubTabel->update($request->all());
        return $CategorySubTabel;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return CategorySubTabel::destroy($id);
        //delete CategorySubTabel
        
    }
}
