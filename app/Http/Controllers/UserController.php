<?php

namespace App\Http\Controllers;
////include '/Users/anchaus/Desktop/usoft/app/Support/helpers.php';
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
        $validated =  $request->validate([
            'login'=> 'required|string|unique:users,login',
            'real_name'=> 'required|string',
            'email'=> 'required|email|unique:users,email',
            'password'=> 'required|min:4',
            'role' => 'in:admin,user'
        ]);

        $validated['password'] = Hash::make($validated['password']);

        return User::create($validated);
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

        if($request['avatar'] && isUser(JWTAuth::getToken(), $id)) {
            if(!file_exists('avatars'))
                mkdir('avatars');
            $credentials['profile_picture'] = 'avatars/' . auth()->user()->id . '.png';
            if (file_exists($credentials['profile_picture']))
                    file_put_contents($credentials['profile_picture'], base64_decode($request['avatar']));
            else {
                $file = fopen($credentials['profile_picture'], "w");
                fwrite($file, base64_decode($request['avatar']));
                fclose($file);
            }
            $user = auth()->user();
            $user->image_path = $credentials['profile_picture'];
            $user->save();
        }

        $user = User::find($id);

        $data = [
            'real_name' => ($request->input('real_name') ? $request->input('real_name') : $user->real_name)
        ];
        
        $user->update($data);
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
