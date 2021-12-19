<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'content', 'title', 'section', 'type', 'version_no'
    ];

    protected $table = 'rules';
}
