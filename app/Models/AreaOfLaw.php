<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaOfLaw extends Model
{
    use HasFactory;

    protected $fillable = [
        'area_of_law'
    ];

    protected $table = 'areas_of_laws';
}
