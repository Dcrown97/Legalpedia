<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'photo',
        'bio',
        'dob',
        'role_id',
        'call_to_bar_year',
        'is_active',
        'referrer',
        'license_code',
        'last_seen',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    // protected $uploads = '/media/' ;


    public function getPhotoAttribute($value)
    {
        if($value){
            return url('storage/'.$value);
        }
        return null;
    }


    public function role() {
        return $this->belongsTo(Role::class);
    }

    public function teams() {
        return $this->belongsToMany(Team::class, 'user_team');
    }

    // public function user_teams() {
    //     return $this->belongsToMany(UserTeam::class);
    // }
}
