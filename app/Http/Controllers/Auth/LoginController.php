<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request; // Не забудь про этот импорт

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    */

    use AuthenticatesUsers;

    /**
     * Куда перенаправлять, если "путь назад" не найден (запасной вариант).
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * 1. ПЕРЕОПРЕДЕЛЯЕМ ПОКАЗ ФОРМЫ
     * Запоминаем, откуда пришел пользователь, перед тем как показать ему форму входа.
     */
    public function showLoginForm()
    {
        // Получаем URL, откуда пришел пользователь
        $previousUrl = url()->previous();
        $baseUrl = url('/');

        // Проверяем:
        // 1. Ссылка внутренняя (с нашего сайта)
        // 2. Это НЕ страница входа/регистрации/сброса пароля (чтобы не зациклило)
        if (str_starts_with($previousUrl, $baseUrl) && 
            !str_contains($previousUrl, '/login') && 
            !str_contains($previousUrl, '/register') && 
            !str_contains($previousUrl, '/password')) {
            
            // Сохраняем этот адрес в сессию как "желаемый" (intended)
            session()->put('url.intended', $previousUrl);
        }

        return view('auth.login');
    }

    /**
     * 2. ЧТО ДЕЛАТЬ ПОСЛЕ УСПЕШНОГО ВХОДА
     * Срабатывает, когда логин и пароль верны.
     */
    protected function authenticated(Request $request, $user)
    {
        // --- ДЛЯ АДМИНА ---
        if ($user->is_admin) {
            // redirect()->intended(...) работает так:
            // Если есть сохраненная страница -> перекидывает туда.
            // Если нет (зашел прямо по ссылке /login) -> перекидывает в route('admin.index').
            return redirect()->intended(route('admin.index'));
        }

        // --- ДЛЯ ОБЫЧНОГО КЛИЕНТА ---
        // Если есть сохраненная страница -> туда.
        // Если нет -> на главную ('home').
        return redirect()->intended(route('home'));
    }
}