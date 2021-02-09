<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function create(){
        return view('admin.createCoupon');
    }
    public function store(){

        $data = request()->validate([
            'couponName' => 'required',
            'couponPercent' => 'required',
            'couponOneUsed' => 'required'
        ]);

        Coupon::create([
            'couponName' => $data['couponName'],
            'couponPercent' => $data['couponPercent'],
            'couponOneUsed' => $data['couponOneUsed']
        ]);

            return redirect('/menu');

    }
}
