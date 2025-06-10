<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Puskesmas extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = ['nama', 'super_admin_id'];



    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

}
