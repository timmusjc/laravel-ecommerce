<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{ asset('apple_black.png') }}">
</head>

<body>
    <header class="site-header">
        <div class="header-container">
            <a href="{{ route('home') }}" class="site-logo">
                TEppLE
            </a>
            <!-- Wyszukiwanie -->
            <form action="{{ route('search') }}" method="GET" class="search-form">
                <input type="search" name="query" class="search-input" placeholder="Szukaj" aria-label="Szukaj">
                <button type="submit" class="search-btn" aria-label="Szukaj">
                    <svg fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                    </svg>
                </button>
            </form>
            <!-- Nawigacja -->
            <nav>
                <ul class="main-nav">
                    <li>
                        <a href="{{ route('cart') }}" class="cart-link">
                            <svg fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                            </svg>
                            {{-- Licznik produktów w koszyku --}}
                            @if (session('cart') && count(session('cart')) > 0)
                                <span class="cart-badge">{{ count(session('cart')) }}</span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('home') }}" class="nav-link">Produkty</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Kategorie
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">

                            <li><a class="dropdown-item fw-bold" href="{{ route('categories') }}">Wszystkie
                                    kategorie</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            @php
                                // Это временное решение (см. ниже про правильный способ)
                                $categories = \App\Models\Category::all();
                            @endphp

                            @foreach ($categories as $category)
                                <li>
                                    <a class="dropdown-item" href="{{ route('category', $category->slug) }}">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" class="nav-link">O nas</a>
                    </li>
                    <li>
                        <a href="{{ route('opinie') }}" class="nav-link">Opinie</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            @guest
                                <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16"
                                    style="vertical-align: text-bottom;">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                    <path fill-rule="evenodd"
                                        d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                                </svg>
                            @else
                                @if (Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}"
                                        class="rounded-circle border border-2" width="24" height="24"
                                        style="object-fit: cover; vertical-align: text-bottom;" alt="Avatar">
                                @else
                                    <span class="user-avatar-badge">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </span>
                                @endif
                            @endguest
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            @guest
                                <li>
                                    <a class="dropdown-item" href="{{ route('login') }}">
                                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16"
                                            style="vertical-align: text-bottom; margin-right: 0.5rem;">
                                            <path fill-rule="evenodd"
                                                d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z" />
                                            <path fill-rule="evenodd"
                                                d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
                                        </svg>
                                        Zaloguj się
                                    </a>
                                </li>
                                @if (Route::has('register'))
                                    <li>
                                        <a class="dropdown-item" href="{{ route('register') }}">
                                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16"
                                                style="vertical-align: text-bottom; margin-right: 0.5rem;">
                                                <path
                                                    d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                <path
                                                    d="M2 13c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Z" />
                                            </svg>
                                            Zarejestruj się
                                        </a>
                                    </li>
                                @endif
                            @else
                                <li class="dropdown-header">
                                    {{ Auth::user()->name }}
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile') }}">
                                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16"
                                            style="vertical-align: text-bottom; margin-right: 0.5rem;">
                                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                            <path fill-rule="evenodd"
                                                d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                                        </svg>
                                        Mój Profil
                                    </a>
                                </li>
                                @if (Auth::user()->is_admin)
                                    <li>
                                        <a class="dropdown-item text-danger" href="{{ route('admin.index') }}">
                                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16"
                                                style="vertical-align: text-bottom; margin-right: 0.5rem;">
                                                <path
                                                    d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z" />
                                                <path
                                                    d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319z" />
                                            </svg>
                                            Panel Admina
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16"
                                            style="vertical-align: text-bottom; margin-right: 0.5rem;">
                                            <path fill-rule="evenodd"
                                                d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z" />
                                            <path fill-rule="evenodd"
                                                d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
                                        </svg>
                                        Wyloguj się
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            @endguest
                        </ul>
                    </li>
                </ul>
            </nav>

            {{-- Кнопка мобильного меню (можно реализовать позже) --}}
            <button class="mobile-menu-btn" aria-label="Menu">
                <svg fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5" />
                </svg>
            </button>
        </div>
    </header>

    <!-- Основной контент -->
    <main class="">
        @yield('main_content')
    </main>

    <!-- Футер -->
    <footer class="site-footer">
        <div class="footer-container">
            <ul class="footer-nav">
                <li><a href="{{ route('cart') }}" class="footer-link">Koszyk</a></li>
                <li><a href="{{ route('home') }}" class="footer-link">Produkty</a></li>
                <li><a href="{{ route('categories') }}" class="footer-link">Kategorie</a></li>
                <li><a href="{{ route('about') }}" class="footer-link">O nas</a></li>
                <li><a href="{{ route('opinie') }}" class="footer-link">Opinie</a></li>
            </ul>
            <p class="footer-copyright">© 2026 Tymofii Korzh</p>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuBtn = document.querySelector('.mobile-menu-btn');
            const navMenu = document.querySelector('.main-nav');

            if (menuBtn && navMenu) {
                menuBtn.addEventListener('click', function() {
                    navMenu.classList.toggle('active');
                });
            }
        });
    </script>
</body>

</html>
