<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        $orders = $user->orders()->with('items.product')->latest()->get();
        return view('profile', compact('user', 'orders'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $user->name = $request->name;
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }
        $user->save();
        return redirect()->route('profile')
        ->with('success', 'Profil został zaktualizowany!');
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password'
             => 'Obecne hasło jest nieprawidłowe']);
        }
        $user->password = Hash::make($request->password);
        $user->save();
        return back()->with('success', 'Hasło zostało zmienione pomyślnie!');
    }
    
}
