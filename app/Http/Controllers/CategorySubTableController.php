<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\CategorySubTabel;

//////////////// remove able to send request to this controller


class CategorySubTableController extends Controller
{
    public function index()
    {
        //get CategorySubTabel
        return CategorySubTabel::all();
    }//to delete

    
    public function store(Request $request)
    {
        return CategorySubTabel::create($request->all());
    }// to delet

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

    public function getCategoriesForPost($postID) {
        return DB::select("select * from category_sub where post_id = $postID;");
    }
    
    public function show($id)
    {
        //show CategorySubTabel
        return CategorySubTabel::find($id);
    }//to delete


    public function update(Request $request, $id)
    {
        //update CategorySubTabel
        $CategorySubTabel = CategorySubTabel::find($id);
        $CategorySubTabel->update($request->all());
        return $CategorySubTabel;
    }//to delet

    public function destroy($id)
    {
        return CategorySubTabel::destroy($id);
        //delete CategorySubTabel
    }// to delete
}
