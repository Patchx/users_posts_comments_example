<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Note, for the sake of a simple Proof of Concept, there are some redundant / non-normalized fields in this table when compared to the users table/Model. In a real-world application we would save a comment_author_user_id so that we could join this table on the users table to get the name and email of the comment author
// --
class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'postId',
        'name',
        'email',
        'body',
    ];
}
