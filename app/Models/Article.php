<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'content', 'user_id', 'article_type', 'display_type', 'link', 'photo', 'area_of_law', 'references',
        'authur', 'category', 'featured'
    ];

    public function getPhotoAttribute($value)
    {
        if($value){
            return url('storage/'.$value);
        }
        return null;
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

}
