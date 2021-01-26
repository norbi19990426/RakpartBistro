<?php

namespace App\Http\Controllers;

use App\Http\Response;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\User;
use DateTime;
use GrahamCampbell\ResultType\Success;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class CartsController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            $id = Auth::id();
            $user = Cart::all();
           $this->loggedUserCart();
        }
        else{
            $id = 0;
            $user = 0;
        }

        return view('foods.cart', compact('id', 'user'));
    }

    //VENDÉG CART-JA
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
            $quantity += $cart[$id]['quantity'];
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return response()->json(['quantity' => $quantity]);
    }
    public function updateItemSum($id)
    {

       // $file=fopen('../storage/app/test.json','w');
        //line = date("h:i:sa:u");
        //fwrite($file,json_encode($line)."\r");
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
        /*$line = date("h:i:sa:u");
        fwrite($file,json_encode($line));
        fclose($file);*/
        return response()->json
        (
        [
            'quantity' => $cart[$id]['quantity'],
            'sub_total' => $cart[$id]['price'] * $cart[$id]['quantity']
        ],
            200
        );
    }

    public function updateItemSub($id)
    {
        $cart = session()->get('cart');
        if (isset($cart[$id])) {
            $cart[$id]['quantity']--;
            session()->put('cart', $cart);

        }
        return response()->json
        (
            [
                'quantity' => $cart[$id]['quantity'],
                'sub_total' => $cart[$id]['price'] * $cart[$id]['quantity'],
            ],
            200
        );

    }
    //REGISZTRÁLT FELHASZNÁLÓ CART-JA
    public function addToUserCart($foodId, $userId){

            $cart = session()->get('cart');
            $decision = DB::table('carts')->whereIn('user_id', [$userId])->whereIn('food_id', [$foodId])->get();

            if(count($decision) == 0){
           DB::table('carts')
                ->insert(['user_id' => $userId,
                'food_id' => $cart[$foodId]['id'],
                'qty' => $cart[$foodId]['quantity']]);
            }
            DB::table('carts')
                ->where('user_id', "=", $userId)
                ->where('food_id', '=', $foodId)
                ->update(['qty' => $cart[$foodId]['quantity']]);

                session()->put('cart', $cart);
    }
    public function removeFromUserCart($foodId, $userId){

        DB::table('carts')
            ->whereIn('user_id', [$userId])
            ->whereIn('food_id', [$foodId])->delete();

    }
    // A hozzáadás gombbal vannak problémák, ki-be lépés vagy már helyszínen, ha be van jelentkezve (Esetleges probléma hogy
    // a hozzáadás növelés csökkentés egy functionon van)
    public function loggedUserCart(){
        if(count(DB::table('carts')->get()) != 0){
            $userCart = Cart::all();
            $food = Food::all();
            $cart = session()->get('cart');
                foreach($userCart as $cartItem){
                    foreach($food as $foodItem){
                        if($cartItem['food_id'] == $foodItem['id'] && $cartItem['user_id'] === Auth::id()){

                            $userFood[] = [
                                'id'        => $foodItem['id'],
                                'name'      => $foodItem['foodName'],
                                'quantity'  => $cartItem['qty'],
                                'price'     => $foodItem['price'],
                                'image'     => $foodItem['image']
                            ];

                            $cart = $userFood;
                            session()->put('cart', $cart);
                    }
                }
            }
        }
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
