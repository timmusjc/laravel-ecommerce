<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{ asset('apple_black.png') }}">
    
   
</head>

<body class="">
    <!-- Хедер -->
    <header class="site-header">
        <div class="header-container">
            <!-- Логотип -->
            <a href="{{ route('home') }}" class="site-logo">
                TEppLE
            </a>
            
            <!-- Поиск -->
            <form action="{{ route('search') }}" method="GET" class="search-form">
                <input 
                    type="search" 
                    name="query" 
                    class="search-input" 
                    placeholder="Szukaj"
                    aria-label="Szukaj">
                <button type="submit" class="search-btn" aria-label="Szukaj">
                    <svg fill="currentColor" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                    </svg>
                </button>
            </form>
            
            <!-- Навигация -->
            <nav>
                <ul class="main-nav">
                    <li>
                        <a href="{{ route('cart') }}" class="cart-link">
                            <svg fill="currentColor" viewBox="0 0 16 16">
                                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                            </svg>
                            {{-- Опционально: счетчик товаров в корзине --}}
                            @if(session('cart') && count(session('cart')) > 0)
                                <span class="cart-badge">{{ count(session('cart')) }}</span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('home') }}" class="nav-link">Produkty</a>
                    </li>
                    <li>
                        <a href="{{ route('categories') }}" class="nav-link">Kategorie</a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" class="nav-link">O nas</a>
                    </li>
                    <li>
                        <a href="{{ route('opinie') }}" class="nav-link">Opinie</a>
                    </li>
                </ul>
            </nav>
            
            {{-- Кнопка мобильного меню (можно реализовать позже) --}}
            <button class="mobile-menu-btn" aria-label="Menu">
                <svg fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
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
            <p class="footer-copyright">© 2025 Sklepik u Tima</p>
        </div>
    </footer>

</body>

</html>