<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{ asset('apple_black.png') }}">
</head>

<body class="min-h-screen flex flex-col">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom"> <a href="{{ route('home') }}"
            class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none"> <svg
                class="bi me-2" width="40" height="32" aria-hidden="true">
                <use xlink:href="#bootstrap"></use>
            </svg> <span class="fs-4">Sklepik u Tima</span> </a>

        <ul class="nav nav-pills">
            <li class="nav-item">
                <form action="{{ route('search')}}" class="d-flex" method="GET" role="search"> 
                    <input class="form-control me-2" type="search"
                        placeholder="Szukaj" aria-label="Search" name="query"> 
                        <button class="btn btn-outline-success" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                        </svg>
                    </button> 
                </form>
            </li>
            <li class="nav-item">
                <a href="{{ route('cart') }}" class="nav-link text-dark">
                    <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="currentColor"
                        class="bi bi-cart" viewBox="0 0 16 16">
                        <path
                            d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                    </svg>
                </a>
            </li>
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
            <li class="nav-item"><a href="{{ route('categories') }}"
                    class="nav-link px-2 text-body-secondary">Kategorie</a></li>
            <li class="nav-item"><a href="{{ route('home') }}" class="nav-link px-2 text-body-secondary">Produkty</a>
            </li>
            <li class="nav-item"><a href="{{ route('opinie') }}" class="nav-link px-2 text-body-secondary">Opinie</a>
            </li>
            <li class="nav-item"><a href="{{ route('about') }}" class="nav-link px-2 text-body-secondary">O nas</a>
            </li>
        </ul>
        <p class="text-center text-body-secondary">© 2025 Sklepik u Tima</p>
    </footer>

</body>

</html>
