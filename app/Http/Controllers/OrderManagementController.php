<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Food;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderManagementController extends Controller
{
    public function index(){

        //$orders = DB::table('orders')->orderBy('created_at')->get();
//        dd($orders);
        $orders = Order::all();
        $statuses = OrderStatus::all();
        //dd($orders[0]->orderitem()->get());
        //dd($orders[0]->orderstatus()->get());
        //dd($statuses->get(0)->order());
        $coupons = Coupon::all();
        $orderItems = OrderItem::all();
        $food = Food::all();
        return view('admin.orderManagement', compact('orders', 'orderItems', 'food', 'statuses', 'coupons'));
    }
    public function orderRemove($orderId){
        DB::table('orders')
            ->whereIn('id', [$orderId])->delete();
        DB::table('order_items')
            ->whereIn('order_id', [$orderId])->delete();
    }
    public function changeOrderStatus($orderId, $statusId){
        DB::table('orders')
            ->whereIn('id', [$orderId])
            ->update(['status' => $statusId]);
    }
}
