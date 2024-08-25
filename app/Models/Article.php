<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Article extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'title', 'description', 'content', 'user_id', 'article_type', 'display_type', 'link', 'photo', 'area_of_law', 'references',
        'authur', 'category', 'featured'
    ];

    public function toSearchableArray()
    {
        $array = $this->toArray();

        // Applies Scout Extended default transformations:
        $array = $this->transform($array);

        return $array;
    }

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
