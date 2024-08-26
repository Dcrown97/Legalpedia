<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// use Laravel\Passport\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
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
        'featured',
        'api_access_token',
        'area_of_practice',
        'nba_branch',
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


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }    


    // protected $uploads = '/media/' ;
    public function getPhotoAttribute($value)
    {
        if($value){
            return url('storage/'.$value);
        }
        return null;
    }


    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\MailResetPasswordNotification($token));
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
        if(isset($this->package_id) && !empty($this->package_id) && $this->expiry_date > now() && $this->status == 'active') {
            return true;
        }
        return false;
    }

    public function pendingUser() {
        if(isset($this->package_id) && !empty($this->package_id) && $this->expiry_date > now() && $this->status == 'inactive') {
            return true;
        }
        return false;
    }

    public function expiredUser() {
        if(isset($this->package_id) && !empty($this->package_id) && $this->expiry_date < now()) {
            return true;
        }
        return false;
    }

    public function teams() {
        return $this->belongsToMany(Team::class, 'user_team');
    }

    public function canUseAi(){
        if(isset($this->package_id) && !empty($this->package_id) && $this->expiry_date > now() && $this->status == 'active') {
            $packages = Package::find($this->package_id);
            if($packages->ai_feature !== null){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
        
    }

    public function canUseAiCounsel(){
        if(isset($this->package_id) && !empty($this->package_id) && $this->expiry_date > now() && $this->status == 'active') {
            $packages = Package::find($this->package_id);
            if($packages->ai_counsel !== null){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
        
    }

    // public function user_teams() {
    //     return $this->belongsToMany(UserTeam::class);
    // }
    public function package()
    {
        return $this->hasOne(Package::class, 'id', 'package_id');
    }
}
