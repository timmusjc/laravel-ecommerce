<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Показать форму оформления
    public function create()
    {
        // Получаем корзину из сессии
        $cart = session()->get('cart', []);

        // Если корзина пуста, нельзя оформлять
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Koszyk pusty!');
        }

        // Считаем общую сумму (если ты не считал её ранее)
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('checkout', compact('cart', 'total'));
    }
    // Сохранить заказ в БД
    public function store(Request $request)
    {
        // 1. Валидация данных формы
        $request->validate([
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        // 2. Получаем корзину
        $cart = session()->get('cart');
        
        // Считаем сумму
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // 3. Создаем ЗАКАЗ в таблице orders
        $order = Order::create([
            'user_id' => Auth::id(), // ID текущего пользователя
            'status' => 'new',
            'total_price' => $total,
            'address' => $request->address,
            'phone' => $request->phone,
            'comment' => $request->comment,
        ]);

        // 4. Переносим товары из корзины в order_items
        foreach ($cart as $id => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        // 5. Очищаем корзину
        session()->forget('cart');

        // 6. Отправляем на страницу "Спасибо"
        return redirect()->route('home')->with('success', 'Zamówienie №' . $order->id . ' zostało złożone!');
    }

}
