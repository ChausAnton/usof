<?php

namespace App\Http\Controllers;
include '/Users/antoncaus/Desktop/usoft/app/Support/helpers.php';
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;


class UserController extends Controller
{

    public function index()
    {
        //get users
        if(!isAdmin(auth()->user())) {
            return "only admin can see all profiles";
        }
        return User::all();
    }


    public function store(Request $request)
    {
        //create a user 
             
        return User::create($request->all());
    } // in future needed to delete

    
    public function show($id)
    {
        //show user
        return User::find($id);
    }

   
    public function update(Request $request, $id)
    {
        //update user
        if(!isAdmin(auth()->user()) && !isUser(JWTAuth::getToken(), $id)) {
            return "only admin and owner of account can change account's data";
        }
        $user = User::find($id);
        $user->update($request->all());
        return $user;
    }

   
    public function destroy($id)
    {
        if(!isAdmin(auth()->user())) {
            return "only admin can delete user";
        }
        return User::destroy($id);
        //delete user
        
    }
}
