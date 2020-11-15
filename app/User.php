<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get all of the user's rate.
     */
    public function getImageAttribute($value)
    {
        if(is_null($value)){
            return asset('default-image.jpg');
        }
        return config('app.url') . \Storage::url($value);
    }

    /**
     * Get user's followers.
     */
    public function followers(){
        return $this->belongsToMany('App\User','user_followers','user_id','follower_id');
    }

    /**
     * Get user's following.
     */
    public function following(){
        return $this->belongsToMany('App\User','user_followers','follower_id','user_id');
    }

    /**
     * Get user's posts.
     */
    public function posts(){
        return $this->hasMany('App\Post','user_id','id');
    }

}
