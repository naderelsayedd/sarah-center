<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\SubscriptionPlan;
use App\User;
class UserSubscriptionPlan extends Model
{
    protected $fillable = [
        'user_id',
        'subscription_plan_id',
        'is_active',
        'expires_at',
    ];

    protected $dates = [
        'expires_at',
    ];

    public function subscription_plan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class,'subscription_plan_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }

}

 ?>