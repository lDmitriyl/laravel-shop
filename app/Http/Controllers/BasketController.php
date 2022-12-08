<?php

namespace App\Http\Controllers;

use App\Classes\Basket;
use App\Http\Requests\AddCouponRequest;
use App\Models\Coupon;
use App\Models\Pro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BasketController extends Controller
{
    public function basket(){

        $order = (new Basket())->getOrder();
        return view('basket', compact('order'));

    }

    public function basketPlace(){
        $basket = new Basket();
        $order = $basket->getOrder();

        if(!$basket->countAvailable()){
            session()->flash('warning', 'Товар не доступен для заказа в полном объёме');
            return redirect()->route('basket');
        }

        return view('order',compact('order'));
    }

    public function basketConfirm(Request $request){

        $basket = new Basket();
        if ($basket->getOrder()->hasCoupon() && !$basket->getOrder()->coupon->availableForUse()) {
            $basket->clearCoupon();
            session()->flash('warning', __('basket.coupon.not_available'));
            return redirect()->route('basket');
        }

        $email = Auth::check() ? Auth::user()->email : $request->email;

        if((new Basket())->saveOrder($request->name, $request->phone, $email)){
            session()->flash('success', 'Ваш заказ принят на обработку');
        }else{
            session()->flash('warning', 'Товар не доступен для заказа в полном объёме');
        }

        return redirect()->route('index');

    }

    public function addBasket(Pro $pro){

        $result = (new Basket(true))->addProduct($pro);
        if($result){
            session()->flash('success', 'Добавлен товар ' . $pro->product->__('name'));
        }else{
            session()->flash('warning', 'Товар ' . $pro->product->__('name')   . ' в большем количестве не доступен для заказа');
        }


        return redirect()->route('basket');

    }

    public function removeBasket(Pro $pro){

        (new Basket())->removeProduct($pro);

        session()->flash('warning', 'Удалён товар ' . $pro->product->__('name'));

        return redirect()->route('basket');

    }

    public function setCoupon(AddCouponRequest $request){

        $coupon = Coupon::where('code', $request->coupon)->first();

        if($coupon->availableForUse()){

            (new Basket())->setCoupon($coupon);

            session()->flash('success', 'Добавлен купон к заказу');
        } else{
            session()->flash('warning', 'Данный купон не может быть использован ');
        }

        return redirect()->route('basket');
    }
}
