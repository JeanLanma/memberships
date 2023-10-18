<?php

namespace App\Models\Projobi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjobiUser extends Model
{
    use HasFactory;

    protected $connection = 'projobi_mysql';
    protected $table = 'users';

    protected $fillable = [
        'plan_slug',
        'post_limit',
        'is_subscriber',
        'subscription_id',
        'subscription_status',
        'subscription_active_until',
        'updated_at'
    ];

    public function getHasActiveSubscriptionAttribute()
    {
        return  (bool)$this->is_subscriber;
    }
}
