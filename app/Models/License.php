<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    use HasFactory;

    protected $fillable = [
        'package', 'package_id', 'license_code', 'licensed_organisation', 'license_name', 'licensed_days', 'active_users'
    ];
}
