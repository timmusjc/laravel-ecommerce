<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute; // Модель характеристик\
use Illuminate\Support\Str;
use App\Models\User;

class AdminController extends Controller
{

    // === ГЛАВНАЯ ПАНЕЛЬ ===
    public function index()
    {
        // Можно передать немного статистики для красоты
        $stats = [
            'orders_count' => Order::count(),
            'users_count' => User::count(),
            'products_count' => Product::count(),
            'revenue' => Order::where('payment_status', 'paid')->sum('total_price'), // Пример выручки
        ];

        return view('admin.index', compact('stats'));
    }

    //  СПИСОК ЗАКАЗОВ
    public function orders()
    {
        // Загружаем заказы
        $orders = Order::with(['user', 'items.product'])->latest()->paginate(15);

        // Возвращаем view с заказами (переименуем папку позже)
        return view('admin.orders', compact('orders'));
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

    public function deleteOrder(Order $order)
{
    // Opcjonalnie: Jeśli masz relację kaskadową w bazie, items usuną się same.
    // Jeśli nie, warto dodać: $order->items()->delete();
    
    $order->delete();

    return redirect()->back()->with('success', 'Zamówienie zostało trwale usunięte.');
}

    // Метод показа формы
    public function createProduct(Request $request)
    {
        $categories = Category::all();
         $selectedCategoryId = $request->query('category_id');
        return view('admin.products.create', compact('categories', 'selectedCategoryId'));
    }

    // Метод сохранения (САМОЕ ВАЖНОЕ)
    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image', // Главное фото обязательно
            'images.*' => 'image',       // Галерея опционально
        ]);

        // 1. Сохраняем главное фото
        $imagePath = $request->file('image')->store('products', 'public');

        // 2. Создаем товар
        $product = Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'price' => $request->price,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        // 3. Сохраняем Галерею (если есть)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('products/gallery', 'public');
                $product->images()->create(['path' => $path]);
            }
        }

        // 4. МАГИЯ ХАРАКТЕРИСТИК (Attributes)
        // 4. ХАРАКТЕРИСТИКИ
        if ($request->has('specs')) {
            foreach ($request->specs as $spec) {
                if (!empty($spec['name']) && !empty($spec['value'])) {

                    // ШАГ 1: Ищем характеристику или создаем новую
                    // Здесь мы записываем 'unit' в таблицу attributes
                    $attribute = Attribute::firstOrCreate(
                        ['name' => $spec['name']], // Поиск по имени
                        ['unit' => $spec['unit'] ?? null] // Если создаем новую, добавляем unit
                    );

                    // ШАГ 2: Привязываем к товару
                    // В таблицу attribute_product пишем ТОЛЬКО value, так как unit там нет
                    $product->attributes()->attach($attribute->id, [
                        'value' => $spec['value']
                    ]);
                }
            }
        }

        return redirect()->route('product', $product->slug)->with('success', 'Produkt został utworzony!');
    }

    // --- УДАЛЕНИЕ ---
    public function deleteProduct(Product $product)
    {
       // если удаляешь ещё и картинки/связи — делай тут
    $product->attributes()->detach();
    $product->images()->delete(); // если есть relation images()

    $product->delete();

    return redirect()
        ->route('home')
        ->with('success', 'Produkt usunięty!');
    }

    // --- РЕДАКТИРОВАНИЕ (Показ формы) ---
    public function editProduct(Product $product)
    {
        // Предполагается, что у тебя есть категории
        $categories = \App\Models\Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // --- РЕДАКТИРОВАНИЕ (Сохранение изменений) ---
    public function updateProduct(Request $request, Product $product)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required',                 // price может быть text — нормализуем ниже
        'description' => 'nullable|string',
        'category_id' => 'nullable|integer',   // если используешь
        'image' => 'nullable|image|max:4096',

        // ДОП ФОТО (как на create)
        'images' => 'nullable|array',
        'images.*' => 'image|max:4096',

        // УДАЛЕНИЕ ФОТО ГАЛЕРЕИ
        'remove_gallery' => 'nullable|array',
        'remove_gallery.*' => 'integer',

        'specs' => 'nullable|array',
    ]);

    // --- normalize price (если вдруг будет "12,50")
    $priceRaw = (string) $request->input('price');
    $priceRaw = str_replace(' ', '', $priceRaw);
    $priceRaw = str_replace(',', '.', $priceRaw);
    $product->price = (float) $priceRaw;

    // --- update fields
    $product->name = $request->input('name');
    $product->description = $request->input('description');
    // $product->category_id = $request->input('category_id');

    // --- MAIN IMAGE replace
    if ($request->hasFile('image')) {
        // удаляем старый файл, если был
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $path = $request->file('image')->store('products', 'public');
        $product->image = $path;
    }

    $product->save();

    // --- 1) REMOVE selected gallery images
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

    // --- 2) ADD new gallery images (multiple)
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $file) {
            $path = $file->store('products/gallery', 'public');
            $product->images()->create(['path' => $path]);
        }
    }

    // --- 3) SPECS: detach + attach
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

            // если unit передан — обновим (чтобы не было "пусто навсегда")
            if ($unit !== '' && $attribute->unit !== $unit) {
                $attribute->unit = $unit;
                $attribute->save();
            }

            $product->attributes()->attach($attribute->id, [
                'value' => $value
            ]);
        }
    }

    return redirect()
        ->route('admin.products.edit', $product)
        ->with('success', 'Produkt zaktualizowany!');
}


    public function users()
    {
        // Берем всех пользователей с пагинацией (по 10 на страницу)
        // Сортируем от новых к старым
        $users = User::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.users', compact('users'));
    }

    public function deleteUser(User $user)
    {
        // Защита: Нельзя удалить самого себя
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Nie możesz usunąć własnego konta!');
        }

        // Удаляем пользователя
        $user->delete();

        return redirect()->back()->with('success', 'Użytkownik został usunięty.');
    }

    public function toggleRole(User $user)
    {
        // Защита: Нельзя менять роль самому себе
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Nie możesz zmienić uprawnień dla samego siebie!');
        }

        // Переключаем статус (если true -> станет false, если false -> станет true)
        $user->is_admin = !$user->is_admin;
        $user->save();

        // Формируем сообщение в зависимости от того, кем он стал
        $message = $user->is_admin
            ? "Użytkownik $user->name jest teraz Administratorem."
            : "Użytkownik $user->name jest teraz Klientem.";

        return redirect()->back()->with('success', $message);
    }


    public function createCategory()
    {
        return view('admin.categories.create');
    }

    // Сохранение новой категории
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

        // Защита от дубля slug (на всякий)
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

    // Форма редактирования категории
    public function editCategory(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    // Сохранение изменений категории
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

        // если slug меняется и занят — добавим хвост
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

        // удалить текущую картинку по чекбоксу
        if ($request->boolean('remove_image') && $category->image) {
            if (Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }
            $category->image = null;
        }

        // заменить картинку
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

    // Удаление категории
    public function deleteCategory(Category $category)
    {

        if (Product::where('category_id', $category->id)->exists()) {
            return back()->with('error', 'Nie można usunąć kategorii, ponieważ zawiera produkty.');
        }

        // удалить файл изображения
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()
            ->route('categories')
            ->with('success', 'Kategoria została usunięta!');
    }
}
