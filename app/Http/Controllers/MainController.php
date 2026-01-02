<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Contracts\Service\Attribute\Required;

class MainController extends Controller {

    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    
    public function home(Request $request) {
       // 1. Начинаем запрос
    $query = Product::query();

    // 2. Логика сортировки
    if ($request->filled('sort')) {
        switch ($request->sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc'); // Дешевые -> Дорогие
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc'); // Дорогие -> Дешевые
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc'); // Новые -> Старые
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc'); // Старые -> Новые
                break;
            default:
                $query->orderBy('created_at', 'desc'); // По умолчанию новые сверху
                break;
        }
    } else {
        // Сортировка по умолчанию, если ничего не выбрано
        $query->orderBy('created_at', 'desc');
    }

    // 3. Пагинация (например, по 12 товаров на страницу)
    // withQueryString() нужен, чтобы при переходе на 2-ю страницу сортировка не сбрасывалась
    $products = $query->paginate(8)->withQueryString();
        return view('home', compact('products'));
    }

    public function search(Request $request){
        $query = $request->input('query');

        $products = Product::where('name', 'LIKE', "%{$query}%")->orWhere('description', 'LIKE', "%{$query}%")->paginate(12);

        return view('search', compact('products', 'query'));
    }

    public function product($slug) {
        $product = Product::where('slug', $slug)->first();
        return view('product', compact('product'));
    }
    public function categories() {
        $categories = Category::get();
        return view('categories', compact('categories'));
    }

    
    public function about() {
        return view('about');
    }
    
    public function opinie() {
        return view('opinie');
    }
    
    
    public function category($slug){
        $category = Category::where('slug', $slug)->first();
        $products = $category->products;
        return view('category', compact('category', 'products'));
    }
    










    public function opinie_check(Request $request) {
        $valid = $request->validate([
            'email' => 'required|email|min:4|max:100',
            'subject' => 'required|min:4|max:100',
            'message' => 'required|min:4|max:100'
        ]);
    }
}
