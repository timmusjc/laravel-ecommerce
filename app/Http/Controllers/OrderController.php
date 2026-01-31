<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
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

    public function store(Request $request)
    {

         $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('home')->with(
                'error',
                'Twój koszyk jest pusty! Zamówienie zostało już prawdopodobnie złożone.'
            );
        }

        $request->validate([
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',

            'payment_method' => 'required|in:card,blik',

            'card_number' => 'required_if:payment_method,card|digits_between:13,19',
            'blik_code' => 'required_if:payment_method,blik|digits:6',
        ]);

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'status' => 'new',
            'total_price' => $total,
            'address' => $request->address,
            'phone' => $request->phone,
            'comment' => $request->comment,
            'payment_method' => $request->payment_method,
            'payment_status' => 'paid', // opcjonalnie: pending -> paid
        ]);

        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        session()->forget('cart');

        return redirect()->route('success', $order->id);
    }

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
