<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = ['user_id', 'action', 'module', 'details', 'ip_address'];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
