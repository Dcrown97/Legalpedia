<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'photo', 'team_owner', 'user_id'
    ];

    protected $table = 'teams';

    protected $uploads = '/media/' ;

    public function getPhotoAttribute($value)
    {
        return url('storage/'.$value);
    }

    public function user() {
        return $this->hasMany(User::class);
    }

    public function invite() {
        return $this->hasMany(Invite::class);
    }

    public function materials() {
        return $this->hasMany(Material::class);
    }
}
