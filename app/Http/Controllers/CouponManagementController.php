<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponManagementController extends Controller
{
    public function index(){
        $coupons = Coupon::all();

        return view('admin.couponManagement', compact('coupons'));
    }
}
