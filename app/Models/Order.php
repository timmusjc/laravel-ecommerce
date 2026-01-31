<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'status', 'total_price', 'address', 'phone', 'comment', 'payment_method', 'payment_status'];

    // Zamówienie należy do użytkownika
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Zamówienie ma wiele pozycji
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function products()
{
    return $this->belongsToMany(Product::class, 'order_items')
        ->withPivot(['quantity', 'price'])
        ->withTimestamps();
}
}
