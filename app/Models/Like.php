<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type', // team/article/form/note
        'team_id',
        'article_id',
        'form_precedence_id',
        'annotation_id',
        'comment_id',
        'like' // like status - 1 for like, 0 for unlike
    ];
}
