<?php

namespace App\Http\Controllers;

use App\Http\Response;
use Illuminate\Http\Request;
use App\Models\Food;
use GrahamCampbell\ResultType\Success;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\View;

class CartController extends Controller

{
    public function index()
    {

        return view('foods.cart');
    }

    public function addToCart(Food $food)
    {

        $cart = session()->get('cart');

        //Ha üres akkor true
        if (empty($cart)) {
            $cart = [
                $food->id => $this->sessionData($food),
            ];

            return $this->setSessionAndReturnResponse($cart);
        }
        //Ha létezik akkor true
        if (isset($cart[$food->id])) {
            $cart[$food->id]['quantity']++;

            return $this->setSessionAndReturnResponse($cart);
        }
        $cart[$food->id] = $this->sessionData($food);

        return $this->setSessionAndReturnResponse($cart);
    }
    public function removeFromCart($id)
    {
        $cart = session()->get('cart');
        $quantity=0;
        if (isset($cart[$id])) {
            $removeId = $id;
            $quantity += $cart[$id]['quantity'];
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return response()->json(['quantity' => $quantity, 'id' => $removeId]);


    }
    public function updateSum($id)
    {
        $cart = session()->get('cart');
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
            session()->put('cart', $cart);
        }
        else{
            //Akkor jön ide ha nem található a kosárba ezzel az id-al food
            return response()->json
            (
            [
                'message' => "not found"
            ],
                404
            );

        }
        return response()->json
        (
        [
            'quantity' => $cart[$id]['quantity'],
            'sub_total' => $cart[$id]['price'] * $cart[$id]['quantity']
        ],
            200
        );
    }
    public function updateSub($id)
    {
        $cart = session()->get('cart');

        if (isset($cart[$id])) {
            $cart[$id]['quantity']--;
            session()->put('cart', $cart);
        }
        return back();
    }

    protected function sessionData(Food $food)
    {
        return [
            'id'        => $food->id,
            'name'      => $food->foodName,
            'quantity'  => 1,
            'price'     => $food->price,
            'image'     => $food->image
        ];
    }
    protected function setSessionAndReturnResponse($cart)
    {
        session()->put('cart', $cart);
        return redirect()->route('menu.index')->with('success', 'Add to Cart');
    }
}
