<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{
    // Показать страницу профиля
    public function profile()
    {
        $user = Auth::user();

        // Получаем заказы пользователя (с товарами)
        // latest() - сортировка от новых к старым
        $orders = $user->orders()->with('items.product')->latest()->get();

        return view('profile', compact('user', 'orders'));
    }

    // Обновить данные (Аватар, Имя)
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Обновляем имя
        $user->name = $request->name;

        // Если загрузили новую аватарку
        if ($request->hasFile('avatar')) {
            // 1. Удаляем старую (если она была и это не дефолтная картинка)
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            // 2. Сохраняем новую в папку avatars
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Profil został zaktualizowany!');
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed', // confirmed ищет поле password_confirmation
        ]);

        $user = Auth::user();

        // 1. Проверяем, совпадает ли старый пароль с тем, что в базе
        if (!Hash::check($request->current_password, $user->password)) {
            // Если нет - возвращаем ошибку
            return back()->withErrors(['current_password' => 'Obecne hasło jest nieprawidłowe']);
        }

        // 2. Меняем пароль
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Hasło zostało zmienione pomyślnie!');
    }
}
