@extends('layout')

@section('title')
    {{$category->name}}
@endsection

@section('main_content')


<div class="catalog-page py-4 py-md-5">
    <div class="container catalog-container">
        
        <!-- Заголовок категории -->
        <div class="category-header">
            <h1 class="category-title">{{$category->name}}</h1>
            @if(count($products) > 0)
                <p class="category-count">{{ count($products) }} {{ count($products) == 1 ? 'produkt' : (count($products) < 5 ? 'produkty' : 'produktów') }}</p>
            @endif
        </div>
        
        @if(count($products) > 0)
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
            <!-- Сетка товаров -->
            <div class="products-grid">
                @foreach ($products as $product)
                    <div class="product-card">
                        <!-- Изображение товара -->
                        <a href="{{ route('product', $product->slug) }}">
                            <div class="product-image-wrapper">
                                <div class="product-image-inner">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                             alt="{{ $product->name }}"
                                             class="product-image">
                                    @else
                                        <div class="no-image">
                                            <svg width="48" height="48" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                                <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z"/>
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
                                
                                <form action="{{ route('cart.add', $product) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-add-cart">
                                        <svg fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                        </svg>
                                        <span class="d-none d-sm-inline">Dodaj</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Пустая категория -->
            <div class="empty-category">
                <svg class="empty-category-icon" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zM4 15h3v-5H4v5zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3zm3 0h-2v3h2v-3z"/>
                </svg>
                <h2 class="empty-category-title">Brak produktów w tej kategorii</h2>
                <p class="empty-category-text">Produkty pojawią się wkrótce</p>
            </div>
        @endif
        
    </div>
</div>

@endsection