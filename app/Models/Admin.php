<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable 
{
    use HasFactory, Notifiable;

    protected $fillable = ['username', 'password', 'super_admin_id'];

    public function superAdmin()
    {
        return $this->belongsTo(SuperAdmin::class);
    }

    public function dataObats()
    {
        return $this->hasMany(DataObat::class);
    }
}
