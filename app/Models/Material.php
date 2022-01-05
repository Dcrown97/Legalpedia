<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'file', 'team_id', 'file_type', 'file_name'
    ];

    public function team() {
        return $this->belongsTo(Team::class);
    }
}
