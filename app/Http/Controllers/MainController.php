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
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function home(Request $request)
    {
        $query = Product::query();

        $this->applySorting($query, $request);

       $perPage = auth()->user()?->is_admin ? 7 : 8;

        $products = $query->paginate($perPage)->withQueryString();
        return view('home', compact('products'));
    }

   public function search(Request $request)
{
    $searchWord = $request->input('query');

    $perPage = auth()->user()?->is_admin ? 7 : 8;

    $query = Product::where(function ($q) use ($searchWord) {
        $q->where('name', 'LIKE', "%{$searchWord}%")
          ->orWhereHas('category', function ($cat) use ($searchWord) {
              $cat->where('name', 'LIKE', "%{$searchWord}%");
          });
    });

    $this->applySorting($query, $request);

    $products = $query->paginate($perPage)->withQueryString();

    return view('search', [
        'products' => $products,
        'query' => $searchWord
    ]);
}


    public function product($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
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

    public function category($slug, Request $request)
    {   
        $perPage = auth()->user()?->is_admin ? 7 : 8;
        $category = Category::where('slug', $slug)->firstOrFail();
        $query = $category->products();
        $this->applySorting($query, $request);
        $products = $query->paginate($perPage)->withQueryString();
        return view('category', compact('category', 'products'));
    }

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
}
