<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\CouponUsages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CouponManagementController extends Controller
{
    public function index(){
        $coupons = Coupon::all();
        $usage = CouponUsages::all();

        return view('admin.couponManagement', compact('coupons', 'usage'));
    }
    public function couponsRemove($couponId){
        DB::table('coupons')
            ->whereIn('id', [$couponId])->delete();
    }
    public function changeCouponUsage($couponId, $usageId){
        DB::table('coupons')
            ->whereIn('id', [$couponId])
            ->update(['usages_id' => $usageId]);
    }
    public function couponEdit($couponId){
        $data = request();
        $coupon = Coupon::find($couponId);
        $coupon->couponName = $data['couponName'];
        $coupon->couponPercent = $data['couponPercent'];
        $coupon->save();
        return response($data);
    }
}
