<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];

    // Позиция ссылается на товар (чтобы знать название и фото)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
