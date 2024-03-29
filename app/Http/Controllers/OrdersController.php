<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    public function createOrderFromRequest(){

        $data = request()->validate([
            'vezeteknev' => 'required',
            'keresztnev' => 'required',
            'iranyitoszam' => 'required|min:4|max:4',
            'email' => 'required|email',
            'varos' => 'required',
            'address' => 'required',
            'telefonszam' => 'required|min:11|max:15',
            'message' => '',
            'totalPrice' => '',
            'couponId' => ''
        ]);

        $order = Order::create([
            'vezeteknev' => $data['vezeteknev'],
            'keresztnev' => $data['keresztnev'],
            'iranyitoszam' => $data['iranyitoszam'],
            'email' => $data['email'],
            'varos' => $data['varos'],
            'address' => $data['address'],
            'telefonszam' => $data['telefonszam'],
            'message' => $data['message'],
            'totalPrice' => $data['totalPrice'],
            'coupon_id' => $data['couponId']
        ]);


        $cart = session()->get('cart');
        foreach($cart as $cartItem){
            DB::table('order_items')
            ->insert(['order_id' => $order->id,
            'food_id' => $cartItem['id'],
            'qty' => $cartItem['quantity']]);
            if(Auth::check()){
                DB::table('carts')
                ->whereIn('user_id', [Auth::id()])
                ->whereIn('food_id', [$cartItem['id']])->delete();
            }
        }
        session()->forget('cart');

        if(Auth::check()){
            DB::table('users')
            ->whereIn('id', [Auth::id()])
            ->update(['ordered' => 1]);
            DB::table('used_coupons')
            ->whereIn('user_id', [Auth::id()])->delete();

        }
    }
}
