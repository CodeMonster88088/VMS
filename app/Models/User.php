<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Http\Middleware\AdminMiddleware;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'isAdmin', // Include isAdmin in the fillable attributes
        'mfa_token',
        'mfa_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'mfa_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'isAdmin' => 'boolean', // Automatically cast isAdmin as a boolean
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // New hash casting in Laravel 10+
        'mfa_expires_at' => 'datetime',
    ];

    /**
     * Check if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->isAdmin; // Use the casted boolean property
    }
    public function getIsAdminAttribute($value)
    {
        return (bool) $this->attributes['isAdmin'];
    }

}
