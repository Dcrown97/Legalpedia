<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaOfLaw extends Model
{
    use HasFactory;

    protected $fillable = [
        'AreaOfLaw'
    ];

    protected $table = 'areas_of_laws';
}
