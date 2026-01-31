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

    public function showLoginForm()
    {
        $previousUrl = url()->previous();
        $baseUrl = url('/');

        if (str_starts_with($previousUrl, $baseUrl) && 
            !str_contains($previousUrl, '/login') && 
            !str_contains($previousUrl, '/register') && 
            !str_contains($previousUrl, '/password')) {
            
            session()->put('url.intended', $previousUrl);
        }

        return view('auth.login');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->is_admin) {
            return redirect()->intended(route('admin.index'));
        }
        return redirect()->intended(route('home'));
    }
}