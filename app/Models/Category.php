<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function foods(){
        return $this->hasMany(Food::class)->orderBy('created_at', 'DESC');
    }
}
