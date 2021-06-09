<?php
use App\Models\User;

function isAdmin($user) {
    if(!$user || strcmp($user->role, 'admin') != 0) {
        return false;
    }
    return true;
}

function isUser($token, $userId) {
    $user = User::find($userId);
    if($user && strcmp($token, $user->token) == 0) {
        return true;
    }
    return false;
}

function getUserByLogin($login) {
    return DB::table('users')->where('login', $login)->first();
}

function getOnlyAtivePosts($id) {
    if($id) {
        return DB::select("select * from posts where status = 'active' and id = $id;");
    }
    return DB::select("select * from posts where status = 'active';");
}