<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected  $table = 'orders';
    use HasFactory;
    protected $fillable = ['name' , 'email' , 'address' , 'phone' , 'note','product_id','price','image','product_name'];

    public function orderDetail(){
        return $this->hasMany(\App\Models\OrderDetail::class ,  'order_id' , 'id');
    }

    public function orderUserMedias(){
        return $this->hasMany(OrderUserMedia::class,'order_id');
    }
}
