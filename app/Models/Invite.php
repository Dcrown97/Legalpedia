<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    use HasFactory;

    protected $fillable = [
        'email', 'token', 'team_id', 'user_id'
    ];

    public function group() {
        return $this->belongsTo(Team::class);
    }
}
