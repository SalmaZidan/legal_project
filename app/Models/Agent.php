<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function phones()
    {
        return $this->hasMany(AgentPhone::class);
    }

    public function addresses()
    {
        return $this->hasMany(AgentAddress::class, 'agent_id');
    }

    public function documents()
    {
        return $this->hasMany(AgentDocument::class);
    }

    public function issues()
    {
        return $this->belongsToMany(Issue::class);
    }

    
}
