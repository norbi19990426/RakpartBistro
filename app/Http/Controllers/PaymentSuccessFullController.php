<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class PaymentSuccessFullController extends Controller
{
    public function index(){


        return view('more-page.paymentSuccessFull');
    }
}
