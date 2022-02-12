<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'discount_id', 'package_id', 'used'
    ];
}
