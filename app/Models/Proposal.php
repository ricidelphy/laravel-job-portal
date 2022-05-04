<?php

namespace App\Models;

use App\Services\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use hasUuid;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function freelancer()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->with('profile');
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
