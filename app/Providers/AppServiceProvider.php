<?php

namespace App\Providers;

use App\Models\Product;
use App\Observers\ProductObserver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       Schema::defaultStringLength(191);

        Blade::directive('routeactive', function ($route){
            return "<?php echo Route::currentRouteNamed($route) ? 'class=\"active\"' : '' ?>";
        });

        Blade::if('admin', function (){
            return Auth::check() && Auth::user()->isAdmin();
        });

        Blade::directive('ddss', function ($item){
            return "<?php echo $item; exit; ?>";
        });

        Product::observe(ProductObserver::class);
    }
}
