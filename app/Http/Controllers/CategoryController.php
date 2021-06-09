<?php

namespace App\Http\Controllers;

include '/Users/antoncaus/Desktop/usoft/app/Support/helpers.php';
use Illuminate\Http\Request;
use App\Models\Category;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;

class CategoryController extends Controller
{
    public function index()
    {
        //get Category
        if(isAdmin(auth()->user()))
            return Category::all();
    }

    
    public function store(Request $request)
    {
        //create a Category
        if(isAdmin(auth()->user()))
            return Category::create($request->all());
    }

    
    public function show($id)
    {
        //show Category
        return Category::find($id);
    }

    
    public function update(Request $request, $id)
    {
        //update Category
        if(isAdmin(auth()->user())) {
            $Category = Category::find($id);
            $Category->update($request->all());
            return $Category;
        }
    }


    public function destroy($id)
    {
        if(isAdmin(auth()->user()))
            return Category::destroy($id);
        //delete Category
        
    }
}
