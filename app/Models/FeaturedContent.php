<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeaturedContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'type', // users/articles/forms/teams/notes
        'reference_id',
        'rating',
        'review_type', // comment or rating
        'review',
        'featured', /// for now use featured column in resources table for admin only
    ];  
}
