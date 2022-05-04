<?php

namespace App\Models;

use App\Services\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreelancerProfile extends Model
{
    use HasUuid;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
