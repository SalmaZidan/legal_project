<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enemy extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function phones()
    {
        return $this->hasMany(EnemyPhone::class);
    }

    public function addresses()
    {
        return $this->hasMany(EnemyAddress::class, 'enemy_id');
    }
}
