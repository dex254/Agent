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
        
        'role',
        'temp_password',
        'temp_password_expiry',
        'reset_token',
    ];

    protected $hidden = [
        'password',
        'temp_password',
        'reset_token',
        'remember_token',
    ];

    protected $casts = [
        'login_time' => 'datetime',
        'logout_time' => 'datetime',
        'temp_password_expiry' => 'datetime',
    ];
}
