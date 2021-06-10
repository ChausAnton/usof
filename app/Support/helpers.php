<?php

//include '/Users/antoncaus/Desktop/usoft/app/Http/Controllers/CategorySubTableController.php';
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

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
    if(!$author_id) {
        $author_id = DB::select("select * from comments where id = $postID;")[0]->author_id;
        $Comment = Comment::find($postID);
        if(strcmp($like, 'like') == 0)
            $Comment->likes++;
        else
            $Comment->likes--;
        $Comment->save();
    }
    else{
        $post = Post::find($postID);
        if(strcmp($like, 'like') == 0)
            $post->likes++;
        else
            $post->likes--;
        $post->save();
    }

    $user = User::find($author_id);

    if(strcmp($like, 'like') == 0)
        $user->rating++;
    else
        $user->rating--;
    $user->save();
}

function applySortingAdmin($posts) {
    if (!isset($_GET['sort']))
        $_GET['sort'] = 'likes';
    
    switch ($_GET['sort']) {
        case 'likes':
            return array_values($posts->sortByDesc('likes')->all());
            break;
        case 'likes-asc':
            return array_values($posts->sortBy('likes')->all());
            break;
        case 'date':
            return array_values($posts->sortBy('created_at')->all());
            break;
        case 'date-desc':
            return array_values($posts->sortByDesc('created_at')->all());
            break;
        default:
            return array_values($posts->sortByDesc('likes')->all());
            break;
    }
}

function applySortingUser($posts) {
    if (!isset($_GET['sort']))
        $_GET['sort'] = 'likes';
    
    switch ($_GET['sort']) {
        case 'likes':
            return array_values($posts->sortByDesc('likes')->where('status', 'active')->all());
            break;
        case 'likes-asc':
            return array_values($posts->sortBy('likes')->where('status', 'active')->all());
            break;
        case 'date':
            return array_values($posts->sortBy('created_at')->where('status', 'active')->all());
            break;
        case 'date-desc':
            return array_values($posts->sortByDesc('created_at')->where('status', 'active')->all());
            break;
        default:
            return array_values($posts->sortByDesc('likes')->where('status', 'active')->all());
            break;
    }
}

// function addCategories($cat_id, $post_id) {
//     $CategorySub = New CategorySubTableController();
//     $CategorySub->addCategory($cat_id, $post_id);
// }

