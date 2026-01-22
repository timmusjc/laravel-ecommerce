<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Contracts\Service\Attribute\Required;

class MainController extends Controller
{


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



    // ГЛАВНАЯ СТРАНИЦА
    public function home(Request $request)
    {
        $query = Product::query();

        // Применяем сортировку (вынес в отдельную функцию, см. внизу, или можно дублировать)
        $this->applySorting($query, $request);

        // По умолчанию 8 товаров
        $perPage = 8;

        if (auth()->user()?->is_admin) {
            $perPage = 7;
        }

        $products = $query->paginate($perPage)->withQueryString();
        return view('home', compact('products'));
    }

    // ПОИСК (Исправленный)
    public function search(Request $request)
    {
        $searchWord = $request->input('query');

        // 1. Формируем запрос поиска
        $query = Product::where(function ($q) use ($searchWord) {
            $q->where('name', 'LIKE', "%{$searchWord}%")
                ->orWhere('description', 'LIKE', "%{$searchWord}%");
        });

        // 2. Применяем сортировку
        $this->applySorting($query, $request);

        // 3. Пагинация
        $products = $query->paginate(8)->withQueryString();

        // 4. ВОЗВРАТ (ИСПРАВЛЕНО):
        // Передаем данные массивом, так как имена переменных разные ($searchWord -> $query)
        return view('search', [
            'products' => $products,
            'query' => $searchWord
        ]);
    }

    public function product($slug)
    {
        $product = Product::where('slug', $slug)->first();
        return view('product', compact('product'));
    }
    public function categories()
    {
        $categories = Category::get();
        return view('categories', compact('categories'));
    }


    public function about()
    {
        return view('about');
    }

    public function opinie()
    {
        return view('opinie');
    }


    // КАТЕГОРИЯ
    public function category($slug, Request $request)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        // 1. Берем запрос товаров этой категории (важно: скобки (), чтобы получить Builder)
        $query = $category->products();

        // 2. Применяем ту же логику сортировки
        $this->applySorting($query, $request);

        // 3. Пагинация
        $products = $query->paginate(8)->withQueryString();

        return view('category', compact('category', 'products'));
    }

    // ВСПОМОГАТЕЛЬНЫЙ МЕТОД (чтобы не копировать код 3 раза)
    private function applySorting($query, Request $request)
    {
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }
    }

    public function opinie_check(Request $request)
    {
        $valid = $request->validate([
            'email' => 'required|email|min:4|max:100',
            'subject' => 'required|min:4|max:100',
            'message' => 'required|min:4|max:100'
        ]);
    }
}
