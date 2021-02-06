<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderManagementController extends Controller
{
    public function index(){

        $orders = DB::table('orders')->groupBy('created_at')->get();
        $orderItems = OrderItem::all();
        $food = Food::all();
        return view('admin.orderManagement', compact('orders', 'orderItems', 'food'));
    }
    public function orderRemove($orderId){
        DB::table('orders')
            ->whereIn('id', [$orderId])->delete();
        DB::table('order_items')
            ->whereIn('order_id', [$orderId])->delete();
    }
}
