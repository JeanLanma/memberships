<?php

namespace App\Models\Projobi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjobiUser extends Model
{
    use HasFactory;

    protected $connection = 'projobi_mysql';
    protected $table = 'users';

    public function getHasActiveSubscriptionAttribute()
    {
        return  (bool)$this->is_subscriber;
    }
}
