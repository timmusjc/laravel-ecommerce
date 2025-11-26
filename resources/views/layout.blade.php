<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
    <link rel="icon" href="logo.jpg" type="image/png">
</head>

<body class="min-h-screen flex flex-col">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom"> <a href="{{ route('home') }}"
            class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none"> <svg
                class="bi me-2" width="40" height="32" aria-hidden="true">
                <use xlink:href="#bootstrap"></use>
            </svg> <span class="fs-4">Sklepik u Tima</span> </a>
        <ul class="nav nav-pills">
            <li class="nav-item"><a href="{{ route('categories') }}" class="nav-link text-dark">Kategorie</a></li>
            <li class="nav-item"><a href="{{ route('home') }}" class="nav-link text-dark">Produkty</a></li>
            <li class="nav-item"><a href="{{ route('about') }}" class="nav-link text-dark">O nas</a></li>
            <li class="nav-item"><a href="{{ route('opinie') }}" class="nav-link text-dark">Opinie</a></li>
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
