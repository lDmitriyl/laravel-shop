<?php

namespace App\Models;

use App\Mail\SendSubscriptionMessage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Subscription extends Model
{
    protected $fillable = ['email', 'pro_id'];

    public function scopeActiveByProId($query, $proId){
        return $query->where('status', 0)->where('prot_id', $proId);
    }

    public function pro(){
        return $this->belongsTo(Pro::class);
    }

    public static function sendEmailsBySubscription(Pro $pro){

        $subscriptions = self::activeByProId($pro->id)->get();

        foreach ($subscriptions as $subscription){
            Mail::to($subscription->email)->send(new SendSubscriptionMessage($pro));
            $subscription->status = 1;
            $subscription->save();
        }

    }
}
