<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dictionary extends Model
{
    use HasFactory;

    protected $fillable = [
        'version_no', 'content', 'title', 'area_of_law', 'category'
    ];

    protected $table = 'dictionaries';
}
