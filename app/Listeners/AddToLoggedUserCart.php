<?php
namespace App\Listeners;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddToLoggedUserCart{

    public function handle($event){
            $cart = session()->get('cart');
            if(session()->has('cart') === true){
                foreach($cart as $cartItem){
                    DB::table('carts')
                        ->insert(['user_id' => Auth::id(),
                        'food_id' => $cartItem['id'],
                        'qty' => $cartItem['quantity']]);
            }
        }
    }
}
