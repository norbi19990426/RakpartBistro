<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function orderstatus(){
        return $this->belongsTo(OrderStatus::class);
    }
    public function orderitem(){
        return $this->hasMany(OrderItem::class);
    }
}
