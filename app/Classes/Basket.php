<?php


namespace App\Classes;


use App\Mail\OrderCreated;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Pro;
use App\Services\CurrencyConversion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class Basket
{
    protected $order;

    /**
     * Basket constructor.
     * @param false $createOrder
     */
    public function __construct($createOrder = false){

        $order = session('order');
        if(is_null($order) && $createOrder){
            $data = [];
            if(Auth::check()){
                $data['user_id'] = Auth::id();
            }
            $data['currency_id'] = CurrencyConversion::getCurrentCurrencyFromSession()->id;
            $this->order = new Order($data);
            session(['order' => $this->order]);
        }else{
            $this->order = $order;
        }

    }

    public function getOrder()
    {
        return $this->order;
    }

    public function countAvailable($updateCount = false){
        $pros = collect([]);
        foreach ($this->order->pros as $orderPro){

            $pro = Pro::find($orderPro->id);

            if($orderPro->countInOrder > $pro->count){
                return false;
            }

            if($updateCount){
                $pro->count -= $orderPro->countInOrder;
                $pros->push($pro);
            }
        }

        if($updateCount){
            $pros->map->save();
        }
        return true;
    }

    public function saveOrder($name, $phone, $email){

        if(!$this->countAvailable(true)){
            return false;
        }

        $this->order->saveOrder($name, $phone);
        Mail::to($email)->send(new OrderCreated($name, $this->getOrder()));
        return true;

    }

    public function removeProduct(Pro $pro){

        if($this->order->pros->contains($pro)) {
            $pivotRow = $this->order->pros->where('id', $pro->id)->first();
            if ($pivotRow->countInOrder < 2) {
                $this->order->pros->pop($pro);
            } else {
                $pivotRow->countInOrder--;
            }
        }
    }

    public function addProduct(Pro $pro){
        if($this->order->pros->contains($pro)){
            $pivotRow = $this->order->pros->where('id', $pro->id)->first();
            if($pivotRow->countInOrder >= $pro->count){
                return false;
            }
            $pivotRow->countInOrder ++;
        }else{
            if($pro->count === 0){
                return false;
            }
            $pro->countInOrder = 1;
            $this->order->pros->push($pro);
        }

        return true;

    }

    public function setCoupon(Coupon $coupon){

        $this->order->coupon()->associate($coupon);

    }

    public function clearCoupon()
    {
        $this->order->coupon()->dissociate();
    }

}
