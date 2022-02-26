<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
// class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'surname',
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
        'package_id',
        'active_date',
        'expiry_date',
        'status',
        'city',
        'state',
        'country',
        'web_link',
        'facebook',
        'instagram',
        'twitter',
        'email_display',
        'phone_display',
        'dob_display',
        'ctb_display',
        'social_display',
        'web_display',
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

    // public function licensedUser() {
    //     if(!empty($this->license_code)) {
    //         return true;
    //     }
    //     return false;
    // }

    public function subscribedUser() {
        if($this->package_id !== '' && $this->expiry_date > now()) {
            return true;
        }
        return false;
    }

    public function expiredUser() {
        if($this->package_id !== '' && $this->expiry_date < now()) {
            return true;
        }
        return false;
    }

    public function teams() {
        return $this->belongsToMany(Team::class, 'user_team');
    }

    // public function user_teams() {
    //     return $this->belongsToMany(UserTeam::class);
    // }
}
