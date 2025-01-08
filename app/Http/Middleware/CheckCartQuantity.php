<?php

namespace App\Http\Middleware;

use App\Models\Cart;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class CheckCartQuantity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            if (Auth::check() && !session()->has('cart_quantity')) {
                $cartQuantity = Cart::where('user_id', Auth::id())->count();
                session(['cart_quantity' => $cartQuantity]);
            }
        } catch (Throwable $ex) {
        }

        return $next($request);
    }
}
