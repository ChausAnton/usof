<?php

//include '/Users/antoncaus/Desktop/usoft/app/Http/Controllers/CategorySubTableController.php';
use App\Models\User;
use App\Models\Post;

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

function getOnlyAtiveComments($id) {
    if($id) {
        return DB::select("select * from comments where status = 'active' and id = $id;");
    }
    return DB::select("select * from comments where status = 'active';");
}

function changeRating($postID, $like) {
    $author_id = DB::select("select * from posts where id = $postID;")[0]->author_id;
    if(!$author_id)
        $author_id = DB::select("select * from comments where id = $postID;")[0]->author_id;

    $user = User::find($author_id);

    if(strcmp($like, 'like') == 0)
        $user->rating++;
    else
        $user->rating--;
    $user->save();
}

// function addCategories($cat_id, $post_id) {
//     $CategorySub = New CategorySubTableController();
//     $CategorySub->addCategory($cat_id, $post_id);
// }

