<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JudgementPartyA extends Model
{
    use HasFactory;

    protected $fillable = [
        'suit_no', 'party_b_names'
    ];

}
