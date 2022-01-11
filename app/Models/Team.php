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

    // protected $uploads = '/media/' ;

    public function getPhotoAttribute($value)
    {
        if($value){
            return url('storage/'.$value);
        }
        return null;
    }

    public function users() {
        return $this->belongsToMany(User::class);
    }

    // public function user_teams() {
    //     return $this->hasMany(UserTeam::class);
    // }

    public function invite() {
        return $this->hasMany(Invite::class);
    }

    public function materials() {
        return $this->hasMany(Material::class);
    }
}
