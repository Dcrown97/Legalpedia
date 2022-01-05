<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Principle extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_matter_index_id', 'principle'
    ];

    protected $table = 'principles';
}
