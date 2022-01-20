<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicensedUserSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'license_id', 'session_no'
    ];
}
