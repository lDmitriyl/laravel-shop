<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscriptionRequest;
use App\Models\Category;
use App\Http\Requests\ProductsFilterRequest;
use App\Models\Currency;
use App\Models\Pro;
use App\Models\Product;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class MainController extends Controller
{
    public function index(ProductsFilterRequest $request){
        $productOffersQuery = Pro::with(['product','product.category','propertyOptions','propertyOptions.property']);

        if($request->filled('price_from')){
            $productOffersQuery->where('price','>=', $request->price_from);
        }

        if($request->filled('price_to')){
            $productOffersQuery->where('price','<=', $request->price_to);
        }

        foreach (['hit', 'new', 'recommend'] as $field){
            if($request->has($field)){
                $productOffersQuery->whereHas('product', function($query) use ($field){
                    $query->$field();
                });
            }
        }

        $productOffers = $productOffersQuery->paginate(6)->withPath("?" . $request->getQueryString());

        //dd($productOffers[0]);

        return view('index', ['prodOfs' => $productOffers]);

    }

    public function categories(){

        return view('categories');

    }

    public function showCategory($code){

        $category = Category::where('code', $code)->first();

        return view('category', compact('category'));

    }

    public function ProductOffer($categoryCode, $productCode, Pro $pro){

        if($pro->product->code != $productCode){
            abort(404, 'Product not found');
        }
        if($pro->product->category->code != $categoryCode){
            abort(404, 'Category not found');
        }
        return view('product', compact('pro'));

    }

    public function subscribe(SubscriptionRequest $request, Pro $pro){

        Subscription::create(['email' => $request->email, 'pro_id' => $pro->id]);

        return redirect()->back()->with('success','Спасибо, мы сообщи вам о поступлении товара');
    }

    public function changeLocale($locale){

        $availableLocales = ['ru', 'en'];
        if(!in_array($locale, $availableLocales)){
            $locale = config('app.locale');
        }
        session(['locale' => $locale]);
        App::setLocale($locale);
        return redirect()->back();

    }

    public function changeCurrency($currencyCode){

        $currency = Currency::byCode($currencyCode)->firstOrFail();
        session(['currency' => $currency->code]);
        return redirect()->back();

    }
}
