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
    
    'phone' => [
        'required',
        'string',
        'min:9',
        'max:20',
        'regex:/^([0-9\s\-\+]*)$/'
    ],
    
    'payment_method' => 'required|in:card,blik',
    
    // ДОБАВЛЕНО 'nullable'
    'card_number' => [
        'nullable', // <--- Важно!
        'required_if:payment_method,card', 
        'string', 
        'min:13', 
        'max:20', 
        'regex:/^([0-9\s\-\+]*)$/'
    ],
    
    // ИСПРАВЛЕНО 'required' на 'required_if' и добавлено 'nullable'
    'card_year' => [
        'nullable', // <--- Важно!
        'required_if:payment_method,card', // <--- Исправлено! Было просто 'required'
        'string',
        'min:4',
        'max:5',
        'regex:/^([0-9\/]*)$/'
    ],
    
    // ДОБАВЛЕНО 'nullable'
    'card_cvc' => 'nullable|required_if:payment_method,card|digits:3',
    
    // ДОБАВЛЕНО 'nullable'
    'blik_code' => 'nullable|required_if:payment_method,blik|digits:6',
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
            'payment_status' => 'paid',
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

        $order->load(['user', 'items.product']);
        $pdf = Pdf::loadView('order_pdf', compact('order'));
        return $pdf->download('faktura-nr-' . $order->id . '.pdf');
    }
}
