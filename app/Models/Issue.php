<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function agents()
    {
        return $this->belongsToMany(Agent::class)->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function type()
    {
        return $this->hasOne(IssueType::class, 'id', 'issue_type_id');
    }

    public function accounts()
    {
        return $this->hasMany(IssueAccount::class, 'issue_id' , 'id');
    }

}
