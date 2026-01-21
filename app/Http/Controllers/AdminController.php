<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute; // Модель характеристик\
use Illuminate\Support\Str;
use App\Models\User;

class AdminController extends Controller
{
   // ГЛАВНАЯ АДМИНКИ = СПИСОК ЗАКАЗОВ
    public function index()
    {
        // Загружаем заказы
        $orders = Order::with(['user', 'items.product'])->latest()->paginate(15);
        
        // Возвращаем view с заказами (переименуем папку позже)
        return view('admin.index', compact('orders'));
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

    // Метод показа формы
public function createProduct()
{
    $categories = Category::all();
    return view('admin.products.create', compact('categories'));
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
        // Если есть картинка - можно её удалить с диска (по желанию)
        // if ($product->image) { Storage::disk('public')->delete($product->image); }

        $product->delete();
        return back()->with('success', 'Produkt został usunięty!');
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
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'nullable',
            'image' => 'nullable|image'
        ]);

        // Обновляем данные
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        // $product->category_id = $request->category_id; // Если используешь категории

        // Если загрузили новую картинку
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
        }

        $product->save();

        // 1. Удаляем старые связи
$product->attributes()->detach(); 

// 2. Записываем новые (те, что пришли из формы)
if ($request->has('specs')) {
    foreach ($request->specs as $spec) {
        if (!empty($spec['name']) && !empty($spec['value'])) {
             $attribute = Attribute::firstOrCreate(
                ['name' => $spec['name']],
                ['unit' => $spec['unit'] ?? null]
            );

            $product->attributes()->attach($attribute->id, [
                'value' => $spec['value']
            ]);
        }
    }
}

        return redirect()->route('home')->with('success', 'Produkt zaktualizowany!');
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
}


