<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'reference', 'package', 'amount', 'status', 'user_id', 'package_id', 'discounted_price'
    ];

}
