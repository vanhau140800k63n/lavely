<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use App\Cart;
use Session;

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
        view()->composer('cart_detail',function($view){
            if(Session('cart')){
                $oldCart = Session::get('cart',null);
                $cart = new Cart($oldCart);
                $view->with(['cart'=>Session::get('cart'),'totalQty'=>$cart->totalQty]);
            }
        }); 
    }
}
