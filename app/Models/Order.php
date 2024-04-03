<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected  $table = 'orders';
    use HasFactory;
    protected $fillable = ['name' , 'email' , 'address' , 'phone' , 'note'];

    public function orderDetail(){
        return $this->hasMany(\App\Models\OrderDetail::class ,  'order_id' , 'id');
    }
}
