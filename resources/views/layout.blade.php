<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{asset ('apple_black.png') }}">
</head>

<body class="min-h-screen flex flex-col">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom"> <a href="{{ route('home') }}"
            class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none"> <svg
                class="bi me-2" width="40" height="32" aria-hidden="true">
                <use xlink:href="#bootstrap"></use>
            </svg> <span class="fs-4">Sklepik u Tima</span> </a>
        <ul class="nav nav-pills">
            <li class="nav-item"><a href="{{ route('categories') }}" class="nav-link"><div class="liquidGlass-wrapper button">
                        <div class="liquidGlass-effect"></div>
                        <div class="liquidGlass-tint"></div>
                        <div class="liquidGlass-shine"></div>
                        <div class="liquidGlass-text">
                            Kategorie
                        </div>
                    </div></a></li>
            <li class="nav-item"><a href="{{ route('home') }}" class="nav-link"><div class="liquidGlass-wrapper button">
                        <div class="liquidGlass-effect"></div>
                        <div class="liquidGlass-tint"></div>
                        <div class="liquidGlass-shine"></div>
                        <div class="liquidGlass-text">
                            Produkty
                        </div>
                    </div></a></li>
            <li class="nav-item"><a href="{{ route('about') }}" class="nav-link"><div class="liquidGlass-wrapper button">
                        <div class="liquidGlass-effect"></div>
                        <div class="liquidGlass-tint"></div>
                        <div class="liquidGlass-shine"></div>
                        <div class="liquidGlass-text">
                            O nas
                        </div>
                    </div></a></li>
            <li class="nav-item"><a href="{{ route('opinie') }}" class="nav-link"><div class="liquidGlass-wrapper button">
                        <div class="liquidGlass-effect"></div>
                        <div class="liquidGlass-tint"></div>
                        <div class="liquidGlass-shine"></div>
                        <div class="liquidGlass-text">
                            Opinie
                        </div>
                    </div></a></li>
        </ul>
    </header>
    <main class="flex-grow">
        @yield('main_content')
    </main>
    <footer class="py-3 my-4 border-top mt-auto">
        <ul class="nav justify-content-center border-bottom pb-3 mb-3">
            <li class="nav-item"><a href="{{ route('home') }}" class="nav-link px-2 text-body-secondary">Home</a></li>
            <li class="nav-item"><a href="{{ route('categories') }}" class="nav-link px-2 text-body-secondary">Kategorie</a></li>
            <li class="nav-item"><a href="{{ route('home') }}" class="nav-link px-2 text-body-secondary">Produkty</a></li>
            <li class="nav-item"><a href="{{ route('opinie') }}" class="nav-link px-2 text-body-secondary">Opinie</a></li>
            <li class="nav-item"><a href="{{ route('about') }}" class="nav-link px-2 text-body-secondary">O nas</a></li>
        </ul>
        <p class="text-center text-body-secondary">© 2025 Sklepik u Tima</p>
    </footer>

</body>

</html>
