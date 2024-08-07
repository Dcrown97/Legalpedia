<?php

namespace App\Models;

use Complex\Functions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JudgementCoram extends Model
{
    use HasFactory;

    protected $fillable = [
        'coram_id', 'suit_no'
    ];

    protected $with = ['coram'];

    public function coram () {
        return $this->hasOne(Coram::class, 'id', 'coram_id');
    }
}
