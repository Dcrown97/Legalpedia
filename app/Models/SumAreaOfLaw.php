<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SumAreaOfLaw extends Model
{
    use HasFactory;

    protected $fillable = [
        'suit_no', 'area_of_law'
    ];

    protected $table = 'sum_area_of_laws';
}
