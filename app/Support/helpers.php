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