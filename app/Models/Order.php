<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'status', 'total_price', 'address', 'phone', 'comment', 'payment_method', 'payment_status'];

    // Заказ принадлежит пользователю
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // В заказе много позиций
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
