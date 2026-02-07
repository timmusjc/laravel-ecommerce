@extends('layout')

@section('title')
    TEppLE
@endsection

@section('main_content')
    <div class="catalog-page py-4 py-md-5">
        {{-- <div class="container-fluid p-0 mb-5"> <div class="container catalog-container"> <div id="heroCarousel" class="carousel slide carousel-fade hero-card shadow-lg" data-bs-ride="carousel" data-bs-interval="5000">
            
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
            </div>

            <div class="carousel-inner">
                
                <div class="carousel-item active hero-item">
                    <img src="hero_iphone.jpg" 
                         class="d-block w-100 hero-img" 
                         alt="iPhone 15 Pro">
                    
                    <div class="carousel-caption hero-caption">
                        <h2 class="hero-title text-white">iPhone 17 Pro Max</h2>
                        <p class="hero-subtitle text-white-50">Tytan. Tak mocny. Tak lekki. Tak Pro.</p>
                        <div class="hero-btns">
                            <a href="product/apple_iphone_17_pro_max_256gb" class="btn btn-primary btn-apple rounded-pill px-4 py-2">
                                Kup teraz
                            </a>
                            <a href="{{ route('category', 'smartfony') }}" class="btn btn-link text-white text-decoration-none">
                                Zobacz wszystkie >
                            </a>
                        </div>
                    </div>
                </div>

                <div class="carousel-item hero-item">
                    <img src="hero_macbook.jpg" 
                         class="d-block w-100 hero-img" 
                         alt="MacBook">
                    
                    <div class="carousel-caption hero-caption text-dark">
                        <h2 class="hero-title text-dark">MacBook Air 15"</h2>
                        <p class="hero-subtitle text-secondary">Imponująco duży. Niewiarygodnie smukły.</p>
                        <div class="hero-btns">
                            <a href="#" class="btn btn-dark btn-apple rounded-pill px-4 py-2">
                                Sprawdź
                            </a>
                            <a href="#" class="btn btn-link text-dark text-decoration-none">
                                Dowiedz się więcej >
                            </a>
                        </div>
                    </div>
                </div>

                <div class="carousel-item hero-item">
                    <img src="https://images.unsplash.com/photo-1606220838315-056192d5e927?q=80&w=2070&auto=format&fit=crop" 
                         class="d-block w-100 hero-img" 
                         alt="Akcesoria">
                    
                    <div class="carousel-caption hero-caption">
                        <h2 class="hero-title text-white">Akcesoria</h2>
                        <p class="hero-subtitle text-white-50">Dopełnij swój styl.</p>
                        <div class="hero-btns">
                            <a href="#" class="btn btn-light btn-apple rounded-pill px-4 py-2">
                                Przeglądaj
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bg-dark rounded-circle bg-opacity-25 p-3" aria-hidden="true"></span>
                <span class="visually-hidden">Poprzedni</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon bg-dark rounded-circle bg-opacity-25 p-3" aria-hidden="true"></span>
                <span class="visually-hidden">Następny</span>
            </button>
        </div>
    </div>
</div> --}}
        <div class="container catalog-container">
            
            <div class="catalog-header-controls">
                <div class="sort-dropdown-wrapper">
                    <span class="sort-label">Sortuj:</span>
                    <div class="dropdown">
                        <button class="btn dropdown-toggle sort-dropdown-btn" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            @switch(request('sort'))
                                @case('price_asc')
                                    Cena: rosnąco
                                @break

                                @case('price_desc')
                                    Cena: malejąco
                                @break

                                @case('oldest')
                                    Najstarsze
                                @break

                                @default
                                    Najnowsze
                            @endswitch
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item {{ request('sort') == 'newest' || !request('sort') ? 'active' : '' }}"
                                    href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}">
                                    Najnowsze
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request('sort') == 'oldest' ? 'active' : '' }}"
                                    href="{{ request()->fullUrlWithQuery(['sort' => 'oldest']) }}">
                                    Najstarsze
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item {{ request('sort') == 'price_asc' ? 'active' : '' }}"
                                    href="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}">
                                    Cena: rosnąco
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request('sort') == 'price_desc' ? 'active' : '' }}"
                                    href="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}">
                                    Cena: malejąco
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="products-grid">
                @auth
                    @if (auth()->user()->is_admin)
                        <div class="product-card">
                            <a href="{{ route('admin.products.create') }}">
                                <div class="product-image-wrapper">
                                    <div class="product-image-inner">
                                        <div class="no-image">
                                            <svg width="48" height="48" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                                                <path
                                                    d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <div class="product-content">
                                <a href="{{ route('admin.products.create') }}" class="product-name">
                                    Dodaj nowy produkt
                                </a>

                                <div class="product-footer">
                                    <div class="product-price">
                                        0 zł
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endauth
                @foreach ($products as $product)
                    <div class="product-card">
                        @auth
                            @if (auth()->user()->is_admin)
                                <div class="admin-controls">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn-admin-edit"
                                        title="Edytuj">
                                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path
                                                d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                        onsubmit="return confirm('Czy na pewno chcesz usunąć ten produkt?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-admin-delete" title="Usuń">
                                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                <path
                                                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                <path fill-rule="evenodd"
                                                    d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endauth

                        <!-- Obraz produktu -->
                        <a href="{{ route('product', $product->slug) }}">
                            <div class="product-image-wrapper">
                                <div class="product-image-inner">
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                            class="product-image">
                                    @else
                                        <div class="no-image">
                                            <svg width="48" height="48" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                                                <path
                                                    d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </a>

                        <!-- Контент карточки -->
                        <div class="product-content">
                            <a href="{{ route('product', $product->slug) }}" class="product-name">
                                {{ $product->name }}
                            </a>

                            <div class="product-footer">
                                <div class="product-price">
                                    {{ number_format($product->price, 2, ',', ' ') }} zł
                                </div>

                                <form action="{{ route('cart.add', $product) }}" method="POST" data-add-to-cart>
                                    @csrf
                                    <button type="submit" class="btn-add-cart">
                                        <svg fill="currentColor" viewBox="0 0 16 16">
                                            <path
                                                d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                        </svg>
                                        <span class="d-none d-sm-inline">Dodaj</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-center mt-5">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
