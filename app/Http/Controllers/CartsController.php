<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Food;
use App\Models\UsedCoupon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartsController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $id = Auth::id();
            $coupons = Coupon::all();
            $usedCoupons = UsedCoupon::all();
            $ordered = DB::table('users')
            ->select('ordered')
            ->whereIn('id', [Auth::id()])->get();
        }
        else {
            $id = 0;
            $ordered = 0;
            $coupons = 0;
            $usedCoupons = 0;
        }

        return view('more-page.cart', compact('id', 'ordered', 'coupons', 'usedCoupons'));
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
        $quantity = 0;
        if (isset($cart[$id])) {
            $quantity += $cart[$id]['quantity'];
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return response()->json(['quantity' => $quantity]);
    }
    public function updateItemSum($id)
    {
        $cart = session()->get('cart');
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
            session()->put('cart', $cart);
        } else {
            //Akkor jön ide ha nem található a kosárba ezzel az id-al food
            return response()->json(
                    [
                        'message' => "not found"
                    ],
                    404
                );
        }
        return response()->json(
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
        return response()->json(
                [
                    'quantity' => $cart[$id]['quantity'],
                    'sub_total' => $cart[$id]['price'] * $cart[$id]['quantity'],
                ],
                200
            );
    }
    //REGISZTRÁLT FELHASZNÁLÓ CART-JA

    public function addToUserCart($foodId, $userId)
    {

        $cart = session()->get('cart');
        $decision = DB::table('carts')->whereIn('user_id', [$userId])->whereIn('food_id', [$foodId])->get();

        if (count($decision) == 0) {
            DB::table('carts')
                ->insert([
                    'user_id' => $userId,
                    'food_id' => $cart[$foodId]['id'],
                    'qty' => $cart[$foodId]['quantity']
                ]);
        }
        DB::table('carts')
            ->where('user_id', "=", $userId)
            ->where('food_id', '=', $foodId)
            ->update(['qty' => $cart[$foodId]['quantity']]);

        session()->put('cart', $cart);
    }
    public function removeFromUserCart($foodId, $userId)
    {

        DB::table('carts')
            ->whereIn('user_id', [$userId])
            ->whereIn('food_id', [$foodId])->delete();
    }
    public function userUseCoupon($userId, $couponId){

        UsedCoupon::create([
            'user_id' => $userId,
            'coupon_id' => $couponId
        ]);

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
