<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Rule extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'name', 'content', 'title', 'section', 'type', 'version_no'
    ];

    protected $table = 'rules';
}
