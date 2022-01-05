<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SummaryRatio extends Model
{
    use HasFactory;

    protected $fillable = [
        'suit_no', 'heading', 'body'
    ];

    protected $table = 'summary_ratios';
}
