<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    
    protected $fillable = [
        'author',
        'user_id',
        'post_id',
        'comment_id',
        'type'
    ];
    
}
