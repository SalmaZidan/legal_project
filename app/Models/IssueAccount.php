<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueAccount extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function type()
    {
        return $this->hasOne(IssueAccountType::class, 'id', 'issue_account_type_id');
    }

}
