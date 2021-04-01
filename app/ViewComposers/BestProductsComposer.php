<?php


namespace App\ViewComposers;


use App\Models\Order;
use App\Models\Pro;
use Illuminate\View\View;

class BestProductsComposer
{
    public function compose(View $view){


        $bestProductIds = Order::get()->map->pros->flatten()->map->pivot->mapToGroups(function ($pivot){
            return [$pivot->pro_id => $pivot->count];
        })->map->sum()->sortByDesc(null)->take(3)->keys()->toArray();

        $bestProducts = Pro::whereIn('id', $bestProductIds)->get();

        $view->with('bestProducts', $bestProducts);
    }
}
