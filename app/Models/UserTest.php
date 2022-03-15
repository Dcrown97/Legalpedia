<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_id'
    ];
    
    protected $table = 'users_old';
}
