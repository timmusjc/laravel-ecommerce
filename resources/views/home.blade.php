@extends('layout')

@section('title')
    TEppLE
@endsection

@section('main_content')



<div class="catalog-page py-4 py-md-5">
    <div class="container catalog-container">

        <form action="{{ url()->current() }}" method="GET" class="sort-form">
                <div class="sort-wrapper">
                    <label for="sort" class="text-muted m-0">Sortuj:</label>
                    <select name="sort" id="sort" class="sort-select" onchange="this.form.submit()">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Najnowsze</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Najstarsze</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Cena: rosnąco</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Cena: malejąco</option>
                    </select>
                </div>
            </form>
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
        <div class="d-flex justify-content-center mt-5">
    {{ $products->links('pagination::bootstrap-5') }}
</div>
    </div>
</div>

@endsection