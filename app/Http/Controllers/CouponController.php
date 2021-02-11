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
            'usages_id' => 'required'
        ]);

        Coupon::create([
            'couponName' => $data['couponName'],
            'couponPercent' => $data['couponPercent'],
            'usages_id' => $data['usages_id']
        ]);

            return redirect('/couponManagement');

    }
}
