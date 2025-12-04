<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'price', 'image', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
{
    return $this->belongsToMany(Order::class, 'order_products');
}

    public function attributes(){
        return $this->belongsToMany(Attribute::class)->withPivot('value');
    }

}
