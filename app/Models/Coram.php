<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coram extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'version_no'
    ];

    protected $table = 'corams';
}
