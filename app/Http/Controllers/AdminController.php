<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class AdminController extends Controller
{
   // ГЛАВНАЯ АДМИНКИ = СПИСОК ЗАКАЗОВ
    public function index()
    {
        // Загружаем заказы
        $orders = Order::with(['user', 'items.product'])->latest()->paginate(15);
        
        // Возвращаем view с заказами (переименуем папку позже)
        return view('admin.index', compact('orders'));
    }

    // Смена статуса заказа
    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:new,processing,completed,cancelled'
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status zamówienia został zmieniony!');
    }

    
    
}


