<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JudgementCoram extends Model
{
    use HasFactory;

    protected $fillable = [
        'coram_id', 'suit_no'
    ];
}
