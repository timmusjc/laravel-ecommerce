<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Support\Str;
use App\Models\User;

class AdminController extends Controller
{

    // Panel główny
    public function index()
    {
        // Statystyki
        $stats = [
            'orders_count' => Order::count(),
            'users_count' => User::count(),
            'products_count' => Product::count(),
            'revenue' => Order::where('payment_status', 'paid')->sum('total_price'), // Пример выручки
        ];

        return view('admin.index', compact('stats'));
    }

    //  Lista zamówień


    public function orders()
    {
        $orders = Order::with(['user', 'items.product'])
        ->latest()->paginate(15);
        return view('admin.orders', compact('orders'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:new,processing,completed,cancelled'
        ]);
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Status zamówienia został zmieniony!');
    }

    public function deleteOrder(Order $order)
    {
        $order->delete();
        return redirect()->back()
        ->with('success', 'Zamówienie zostało trwale usunięte.');
    }

    // Utworzenie nowego produktu
    public function createProduct(Request $request)
    {
        $categories = Category::all();
        $selectedCategoryId = $request->query('category_id');
        return view('admin.products.create', compact('categories', 'selectedCategoryId'));
    }

    // Zapisywanie produktu
    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image',
            'images.*' => 'image',
        ]);

        $imagePath = $request->file('image')->store('products', 'public');
        $product = Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'price' => $request->price,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        // Jeśli są opcjonalne zdjęcia - zapisują się
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('products/gallery', 'public');
                $product->images()->create(['path' => $path]);
            }
        }

        // Specyfikacje
        if ($request->has('specs')) {
            foreach ($request->specs as $spec) {
                if (!empty($spec['name']) && !empty($spec['value'])) {
                    $attribute = Attribute::firstOrCreate(
                        ['name' => $spec['name']],
                        ['unit' => $spec['unit'] ?? null]
                    );
                    $product->attributes()->syncWithoutDetaching([
                        $attribute->id => ['value' => $spec['value']]
                    ]);
                }
            }
        }
        return redirect()->route('product', $product->slug)->with('success', 'Produkt został utworzony!');
    }

    // Usuwanie
    public function deleteProduct(Product $product)
    {
        $product->attributes()->detach();
        $product->images()->delete();

        $product->delete();

        return redirect()
            ->route('home')
            ->with('success', 'Produkt usunięty!');
    }

    // Edytowanie (formularz)
    public function editProduct(Product $product)
    {
        $categories = \App\Models\Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // Edytowanie i zapisywanie
    public function updateProduct(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:4096',
            'images' => 'nullable|array',
            'images.*' => 'image|max:4096',
            'remove_gallery' => 'nullable|array',
            'remove_gallery.*' => 'integer',
            'specs' => 'nullable|array',
        ]);

        // normalize price
        $priceRaw = (string) $request->input('price');
        $priceRaw = str_replace(' ', '', $priceRaw);
        $priceRaw = str_replace(',', '.', $priceRaw);
        $product->price = (float) $priceRaw;

        // update fields
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->category_id = $request->input('category_id');

        // Zmiana zdjęcia głównego
        if ($request->hasFile('image')) {
            // usuwanie starego pliku
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
        }

        $product->save();
        $removeIds = $request->input('remove_gallery', []);
        if (!empty($removeIds)) {
            $imgs = $product->images()->whereIn('id', $removeIds)->get();

            foreach ($imgs as $img) {
                if ($img->path && Storage::disk('public')->exists($img->path)) {
                    Storage::disk('public')->delete($img->path);
                }
                $img->delete();
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('products/gallery', 'public');
                $product->images()->create(['path' => $path]);
            }
        }

        $product->attributes()->detach();

        if ($request->filled('specs')) {
            foreach ($request->input('specs') as $spec) {
                $name = trim($spec['name'] ?? '');
                $value = trim($spec['value'] ?? '');
                $unit = trim($spec['unit'] ?? '');

                if ($name === '' || $value === '') {
                    continue;
                }

                $attribute = Attribute::firstOrCreate(['name' => $name]);

                if ($unit !== '' && $attribute->unit !== $unit) {
                    $attribute->unit = $unit;
                    $attribute->save();
                }

                $product->attributes()->syncWithoutDetaching([
                    $attribute->id => ['value' => $value]
                ]);
            }
        }

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('success', 'Produkt zaktualizowany!');
    }

    // Zarządzanie użytkownikami
    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Nie możesz usunąć własnego konta!');
        }
        $user->delete();

        return redirect()->back()->with('success', 'Użytkownik został usunięty.');
    }

    public function toggleRole(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Nie możesz zmienić uprawnień dla samego siebie!');
        }

        $user->is_admin = !$user->is_admin;
        $user->save();

        $message = $user->is_admin
            ? "Użytkownik $user->name jest teraz Administratorem."
            : "Użytkownik $user->name jest teraz Klientem.";

        return redirect()->back()->with('success', $message);
    }

    // Kategorie
    public function createCategory()
    {
        return view('admin.categories.create');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'slug'  => 'nullable|string|max:255|unique:categories,slug',
            'image' => 'nullable|image|max:4096',
        ]);

        $name = trim($request->input('name'));
        $slugInput = trim((string) $request->input('slug'));

        $slug = $slugInput !== '' ? Str::slug($slugInput) : Str::slug($name);

        if (Category::where('slug', $slug)->exists()) {
            $slug .= '-' . Str::lower(Str::random(4));
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
        }

        $category = Category::create([
            'name'  => $name,
            'slug'  => $slug,
            'image' => $imagePath,
        ]);

        return redirect()
            ->route('categories')
            ->with('success', 'Kategoria została utworzona!');
    }

    public function editCategory(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function updateCategory(Request $request, Category $category)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'slug'  => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'image' => 'nullable|image|max:4096',
            'remove_image' => 'nullable|boolean',
        ]);

        $name = trim($request->input('name'));
        $slugInput = trim((string) $request->input('slug'));

        $newSlug = $slugInput !== '' ? Str::slug($slugInput) : Str::slug($name);

        if ($newSlug !== $category->slug) {
            $exists = Category::where('slug', $newSlug)
                ->where('id', '!=', $category->id)
                ->exists();

            if ($exists) {
                $newSlug .= '-' . Str::lower(Str::random(4));
            }
        }

        $category->name = $name;
        $category->slug = $newSlug;

        if ($request->boolean('remove_image') && $category->image) {
            if (Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }
            $category->image = null;
        }

        if ($request->hasFile('image')) {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }
            $category->image = $request->file('image')->store('categories', 'public');
        }

        $category->save();

        return redirect()
            ->route('categories')
            ->with('success', 'Kategoria została zaktualizowana!');
    }

    public function deleteCategory(Category $category)
    {

        if (Product::where('category_id', $category->id)->exists()) {
            return back()->with('error', 'Nie można usunąć kategorii, ponieważ zawiera produkty.');
        }

        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()
            ->route('categories')
            ->with('success', 'Kategoria została usunięta!');
    }
}
