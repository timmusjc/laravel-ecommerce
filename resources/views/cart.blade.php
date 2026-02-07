@extends('layout')

@section('title')
    Koszyk
@endsection

@section('main_content')

    <div class="container cart-page py-4 py-md-5">
        <h1 class="cart-title">Koszyk</h1>

        @php $total = 0; @endphp

        <div class="row">
            <!-- Lewa kolumna - produkty -->
            <div class="col-lg-8">
                @if (session('cart') && count($cart) > 0)
                    @foreach ($cart as $productId => $product)
                        @php
                            $total += $product['price'] * $product['quantity'];
                        @endphp

                        <div class="cart-item" data-id="{{ $productId }}">
                            <div class="row align-items-center g-3">
                                <!-- Obraz -->
                                <div class="col-md-2 col-3">
                                    <a href="{{ route('product', $product['slug']) }}">
                                        @if ($product['image'])
                                            <img src="{{ asset('storage/' . $product['image']) }}" class="cart-item-image"
                                                alt="{{ $product['name'] }}">
                                        @else
                                            <div class="cart-item-image d-flex align-items-center justify-content-center">
                                                <svg width="32" height="32" fill="currentColor" viewBox="0 0 16 16"
                                                    class="u-muted-icon">
                                                    <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                                                    <path
                                                        d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </a>
                                </div>

                                <!-- Nazwa -->
                                <div class="col-md-4 col-9">
                                    <a href="{{ route('product', $product['slug']) }}" class="cart-item-name">
                                        {{ $product['name'] }}
                                    </a>
                                </div>

                                <!-- Ilość -->
                                <div class="col-md-2 col-4 mobile-spacing">
                                    <label class="d-block text-muted small mb-1">Ilość:</label>
                                    <input type="number" value="{{ $product['quantity'] }}" min="1"
                                        class="form-control quantity-input update-cart" data-id="{{ $productId }}">
                                </div>

                                <!-- Cena -->
                                <div class="col-md-2 col-4 mobile-spacing text-md-center">
                                    <div class="text-muted small mb-1">Cena:</div>
                                    <div class="cart-item-price">{{ number_format($product['price'], 2, ',', ' ') }} zł
                                    </div>
                                </div>

                                <!-- Usuwanie -->
                                <div class="col-md-2 col-4 mobile-spacing text-md-end">
                                    <form action="{{ route('cart.remove', $productId) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-remove w-100">
                                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16"
                                                class="u-text-bottom">
                                                <path
                                                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                <path fill-rule="evenodd"
                                                    d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                            </svg>
                                            <span class=" d-sm-inline">Usuń</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-cart">
                        <svg class="empty-cart-icon" fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                        </svg>
                        <div class="empty-cart-title">Twój koszyk jest pusty</div>
                        <p class="empty-cart-text">Dodaj produkty do koszyka, aby kontynuować zakupy</p>
                        <a href="{{ route('home') }}" class="btn-shop">Przejdź do produktów</a>
                    </div>
                @endif
            </div>

            <!-- Prawa kolumna - podsumowania -->
            @if (session('cart') && count($cart) > 0)
                <div class="col-lg-4">
                    <div class="cart-summary">
                        <h3 class="h5 fw-semibold mb-3">Podsumowanie zamówienia</h3>

                        <div class="summary-row">
                            <span class="summary-label">Produkty ({{ count($cart) }})</span>
                            <span class="summary-value"><span
                                    id="subtotal-price">{{ number_format($total, 2, ',', ' ') }}</span> zł</span>
                        </div>

                        <div class="summary-row">
                            <span class="summary-label">Dostawa</span>
                            <span class="summary-value">Obliczone przy zamówieniu</span>
                        </div>

                        <div class="summary-row">
                            <span class="summary-label summary-total">Razem:</span>
                            <span id="total-price" class="summary-value summary-total">
                            {{ number_format($total, 2, ',', ' ') }} zł</span>
                        </div>

                        <a href="{{ route('checkout') }}">
                            <div class="btn-checkout text-center">
                                Przejdź do zamówienia
                            </div>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script type="text/javascript">
        document.querySelectorAll('.update-cart').forEach(function(element) {
            element.addEventListener('change', function(e) {
                e.preventDefault();

                let ele = this;
                let id = ele.getAttribute('data-id');
                let quantity = ele.value;

                if (quantity < 1) {
                    ele.value = 1;
                    quantity = 1;
                }

                fetch('{{ route('cart.update') }}', {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            id: id,
                            quantity: quantity
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('total-price').innerText = data.total.toFixed(2)
                                .replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
                            document.getElementById('subtotal-price').innerText = data.total.toFixed(2)
                                .replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    </script>

@endsection
