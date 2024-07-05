<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Country extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
