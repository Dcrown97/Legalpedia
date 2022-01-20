<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'note_id', 'content_id', 'content_type', 'content', 'comment', 'replies', 'text_target', 'tags', 'display'
    ];

    protected $table = 'annotations';
}
