<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    // Показать форму оформления
    public function create()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Koszyk pusty!');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('checkout', compact('cart', 'total'));
    }

    // Сохранить заказ в БД (ОБНОВЛЕННЫЙ МЕТОД)
    public function store(Request $request)
    {

    // --- 1. ЗАЩИТА ОТ ПОВТОРНОЙ ОТПРАВКИ (FIX) ---
        // Получаем корзину в самом начале
        $cart = session()->get('cart');

        // Если корзины нет или она пустая — выкидываем пользователя
        // Это спасет от ошибки "foreach argument must be array", если нажать "Назад"
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Twój koszyk jest pusty! Zamówienie zostało już prawdopodobnie złożone.');
        }
        // 1. Валидация данных (Добавили проверку оплаты)
        $request->validate([
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'payment_method' => 'required|in:card,blik', // Обязательно выбрать метод

            // Если выбрана карта, нужен номер
            'card_number' => 'required_if:payment_method,card',
            // Если BLIK, нужен код (6 цифр)
            'blik_code' => 'required_if:payment_method,blik|digits:6|nullable',
        ]);

        // 2. Получаем корзину
        $cart = session()->get('cart');

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // 3. Создаем ЗАКАЗ
        $order = Order::create([
            'user_id' => Auth::id(),
            'status' => 'new',
            'total_price' => $total,
            'address' => $request->address,
            'phone' => $request->phone,
            'comment' => $request->comment,

            // НОВЫЕ ПОЛЯ ОПЛАТЫ
            'payment_method' => $request->payment_method,
            'payment_status' => 'paid', // Сразу ставим "Оплачено" (симуляция)
        ]);

        // 4. Переносим товары
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

        // 6. Редирект
        return redirect()->route('success', $order->id);
    }

    // Остальные методы (success, downloadInvoice) оставляем без изменений...
    public function success(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        return view('success', compact('order'));
    }

    public function downloadInvoice(Order $order)
    {
        if ($order->user_id !== auth()->id() && !auth()->user()->is_admin) {
        abort(403);
    }
        $pdf = Pdf::loadView('order_pdf', compact('order'));
        return $pdf->download('faktura-nr-' . $order->id . '.pdf');
    }
}
