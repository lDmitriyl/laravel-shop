<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'currency_id', 'sum', 'coupon_id'];

    public function pros(){
        return $this->belongsToMany(Pro::class)->withPivot(['count','price'])->withTimestamps();
    }

    public function currency(){
        return $this->belongsTo(Currency::class);
    }

    public function coupon(){
        return $this->belongsTo(Coupon::class);
    }

    public function scopeActive($query){
        $query->where('status', 1);
    }

    public function calculateFullSum(){

        $sum = 0;

        foreach ($this->pros()->withTrashed()->get() as $pro){
            $sum += $pro->getPriceForCount();
        }

        return $sum;
    }

    public function getFullSum($applyCoupon = false){
        $sum = 0;

        foreach ($this->pros as $pro) {
            $sum += $pro->price * $pro->countInOrder;
        }

        if($applyCoupon && $this->hasCoupon()){
            $sum = $this->coupon->applyCost($sum, $this->currency);
        }

        return $sum;
    }

    public function saveOrder($name, $phone){

        $this->name = $name;
        $this->phone = $phone;
        $this->status = 1;
        $this->sum = $this->getFullSum();
        $pros = $this->pros;
        $this->save();

        foreach ($pros as $proInOrder){
            $this->pros()->attach($proInOrder, [
                'count' => $proInOrder->countInOrder,
                'price' => $proInOrder->price
            ]);
        }
        session()->forget('order');
        return true;
    }

    public function hasCoupon(){
        return $this->coupon;
    }
}
