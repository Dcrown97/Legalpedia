<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'team_id',
        'file',
        'file_type',
        'pdf_name',
        'doc_name',
        'zip_name',
        'rar_name',
        'comment_body',
        'article_id'
    ];

    public function getFileAttribute($value)
    {
        return url('storage/'.$value);
    }

    public function team() {
        return $this->belongsTo(Team::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function comment_replies() {
        return $this->hasMany(CommentReply::class)->orderBy('created_at', 'ASC');
    }
}
