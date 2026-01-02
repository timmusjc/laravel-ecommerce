<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class AdminController extends Controller
{
    public function index(){
        return view('admin.index');
    }

    public function orders()
    {
        // Берем все заказы, сортируем от новых к старым
        // with('user') нужен, чтобы сразу подгрузить имена покупателей (оптимизация)
       $orders = Order::with(['user', 'items.product'])
                   ->latest()
                   ->paginate(10);
        
        return view('admin.orders', compact('orders'));
    }
}
