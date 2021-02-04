<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    public function createOrderFromRequest(){

        $data = request()->validate([
            'vezeteknev' => 'required',
            'keresztnev' => 'required',
            'iranyitoszam' => 'required',
            'email' => 'required|email',
            'varos' => 'required',
            'address' => 'required',
            'telefonszam' => 'required',
            'message' => '',
            'totalPrice' => ''
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
            'totalPrice' =>$data['totalPrice']
        ]);

        $cart = session()->get('cart');
        foreach($cart as $cartItem){
            DB::table('order_items')
            ->insert(['order_id' => $order->id,
            'food_id' => $cartItem['id'],
            'qty' => $cartItem['quantity']]);
        }
        session()->forget('cart');

        date_default_timezone_set('Europe/Budapest');
        $timestamp = time() + 60*60;
        $time = date("H:i", $timestamp);
        return redirect()->route('paymentSuccess.index')->with(['time' => $time]);
    }
}
