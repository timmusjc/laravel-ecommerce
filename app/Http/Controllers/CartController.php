<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isNull;

class CartController extends Controller
{
    public function cart()
    {
        // $orderId = session('orderId');
        // if(!is_null($orderId)) {
        //     $order = Order::findOrFail($orderId);
        // }
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
    }

    public function cartAdd(Request $request, $productId)
    {

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $product = Product::findOrFail($productId);

            $cart[$productId] = [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => 1,
                'slug' => $product->slug,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('product_added', 'name');
    }

    public function cartRemove($productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }
        return redirect()->back();
    }

    public function cartUpdate(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart', []);
            if (isset($cart[$request->id])) {
                $cart[$request->id]['quantity'] = $request->quantity;
                session()->put('cart', $cart);
            }

            $total = 0;
            foreach ($cart as $id => $details) {
                $total += $details['price'] * $details['quantity'];
            }

            return response()->json([
                'success' => true,
                'total' => $total
            ]);
        }
    }
}
