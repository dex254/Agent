<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // So it can be authenticated
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // optional if you plan to use Sanctum for API tokens

class Agent extends Authenticatable
{
    use  HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'agent'; // your table name

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'status',
        'login_time',
        'logout_time',
        'profile',
        'activity',
        'securitykey',
        'campus',
        'temporary_password_token',
        'role',
    ];

    /**
     * The attributes that should be hidden for arrays / JSON.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'temporary_password_token',
        'remember_token', // if you add it
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'login_time' => 'datetime',
        'logout_time' => 'datetime',
    ];
}
