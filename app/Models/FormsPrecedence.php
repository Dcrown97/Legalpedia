<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormsPrecedence extends Model
{
    use HasFactory;

    protected $fillable = [
        'version_no', 'content', 'title', 'category', 'area_of_law', 'author'
    ];

    protected $table = 'form_precedences';
}
