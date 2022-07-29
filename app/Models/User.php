<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Overtrue\LaravelVote\Traits\Voter;

class User extends Authenticatable implements JWTSubject
{
    use  HasApiTokens, HasFactory, Notifiable,Voter;

    protected $fillable = [
        'name', 'email', 'password'
    ];

    public function job_vacancies()
    {
        return $this->hasMany(JobVacancies::class, 'user_id');
    }

    public function user_likes()
    {
        return $this->hasMany(UserLikes::class, 'liked_user_id');
    }

    public function responses()
    {
        return $this->hasMany(Responses::class, 'creator_id');
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

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
}
