<?php
namespace App\Listeners;

use App\Models\Cart;
use App\Models\Food;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddToLoggedUserCart{

    public function table(){
            $cart = session()->get('cart');
            $userCart = Cart::all();
            if(session()->has('cart') === true){
                foreach($cart as $cartItem){
                    $decision = DB::table('carts')->whereIn('user_id', [Auth::id()])->whereIn('food_id', [$cartItem['id']])->get();
                    if(count($decision) == 0){
                        DB::table('carts')
                            ->insert(['user_id' => Auth::id(),
                            'food_id' => $cartItem['id'],
                            'qty' => $cartItem['quantity']]);
                    }
                    foreach($userCart as $userItem){
                        if($userItem['food_id'] == $cartItem['id'] && $userItem['user_id'] == Auth::id()){
                        DB::table('carts')
                            ->where('user_id', "=", Auth::id())
                            ->where('food_id', '=', $cartItem['id'])
                            ->update(['qty' => $userItem['qty'] += $cartItem['quantity']]);
                    }
                }
            }
        }
    }
    public function cart(){
        if(count(DB::table('carts')->get()) != 0){
            $cart = session()->get('cart');
            $userCart = Cart::all();
            $food = Food::all();
            $foodUserCart = [];
                foreach($userCart as $cartItem){
                    foreach($food as $foodItem){
                            if($foodItem['id'] == $cartItem['food_id'] && $cartItem['user_id'] === Auth::id()){
                                $cart[$foodItem['id']] = $foodUserCart[] = [
                                        'id'        => $foodItem['id'],
                                        'name'      => $foodItem['foodName'],
                                        'quantity'  => $cartItem['qty'],
                                        'price'     => $foodItem['price'],
                                        'image'     => $foodItem['image']
                                    ];
                            session()->put('cart', $cart);
                    }
                }
            }
        }
    }
}
