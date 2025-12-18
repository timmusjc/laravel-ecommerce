<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth; // <--- 1. ВОТ ЭТО ОЧЕНЬ ВАЖНО

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    */

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // В Laravel 11 это может не работать, но в laravel/ui обычно оставляют.
        // Если будет ошибка - удали конструктор, как мы делали в HomeController.
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    // 2. А ВОТ НАШ МЕТОД ПЕРЕНАПРАВЛЕНИЯ
    protected function redirectTo()
    {
        // Теперь Auth::user() будет работать, так как мы добавили use вверху
        if (Auth::user()->is_admin) {
            return route('admin.index');
        }

        return route('home');
    }
}