@extends('layout')

@section('title')
    Złożenie zamówienia
@endsection

@section('main_content')
    <div class="checkout-page">
        <div class="container cart-page checkout-container">
            <h1 class="cart-title">Złożenie zamówienia</h1>

            <div class="checkout-layout">
                <div class="checkout-summary-col order-md-2">
                    <div class="checkout-summary">
                        <h3 class="summary-title">Twój koszyk</h3>

                        <div class="summary-items">
                            @foreach ($cart as $item)
                                <div class="summary-item">
                                    <div class="summary-item-info">
                                        <div class="summary-item-name">{{ $item['name'] }}</div>
                                        <div class="summary-item-qty">Ilość: {{ $item['quantity'] }}</div>
                                    </div>
                                    <div class="summary-item-price">
                                        {{ number_format($item['price'] * $item['quantity'], 2, ',', ' ') }} zł
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="summary-total">
                            <span>Razem:</span>
                            <strong>{{ number_format($total, 2, ',', ' ') }} zł</strong>
                        </div>
                    </div>
                </div>

                <div class="checkout-form-col order-md-1">
                    <div class="checkout-form-card">

                        <form action="{{ route('order.store') }}" method="POST" class="checkout-form" id="payment-form">
                            @csrf

                            <h3 class="form-section-title mb-3">1. Dane dostawy</h3>

                            <div class="mb-3">
                                <label for="address" class="form-label">Adres dostawy</label>
                                <input type="text" id="address" class="form-control form-input" name="address" required
                                    value="{{ old('address') }}" placeholder="np. Warszawa, Złota 44/2">
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Numer telefonu</label>
                                <input type="tel" id="phone" class="form-control form-input" name="phone" required
                                    value="{{ old('phone') }}" placeholder="+48 123 456 789">
                                    @error('phone')
                                            <div class="invalid-feedback d-block mb-2">{{ $message }}</div>
                                        @enderror
                            </div>

                            <div class="mb-4">
                                <label for="comment" class="form-label">Uwagi (opcjonalnie)</label>
                                <textarea id="comment" class="form-control form-textarea" name="comment" rows="2"></textarea>
                            </div>

                            <h3 class="form-section-title mb-3">2. Metoda płatności</h3>

                            <div class="payment-methods d-grid gap-3 mb-4">

                                <div class="border rounded p-3 position-relative" style="cursor: pointer;"
                                    onclick="selectPayment('card')">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" id="pay_card"
                                            value="card" {{ old('payment_method', 'card') == 'card' ? 'checked' : '' }}>
                                        <label class="form-check-label w-100 fw-bold" for="pay_card">
                                            <img src="visa_mastercard.jpg" alt="BLIK" style="height: 20px;" class="me-2">
                                            <i class="bi bi-credit-card-2-front me-2"></i> Karta płatnicza
                                        </label>
                                    </div>

                                    <div id="card-details"
                                        class="mt-3 ps-4 {{ old('payment_method') == 'blik' ? 'd-none' : '' }}">
                                        <input type="text" name="card_number"
                                            class="form-control mb-2 @error('card_number') is-invalid @enderror"
                                            placeholder="Numer karty (0000 0000...)" value="{{ old('card_number') }}">

                                        @error('card_number')
                                            <div class="invalid-feedback d-block mb-2">{{ $message }}</div>
                                        @enderror

                                        <div class="row g-2">
                                            <div class="col-6">
                                                <input type="text" name="card_year" class="form-control" placeholder="MM/YY">
                                                @error('card_year')
                                            <div class="invalid-feedback d-block mb-2">{{ $message }}</div>
                                        @enderror
                                            </div>
                                            
                                            <div class="col-6">
                                                <input type="text" name="card_cvc" class="form-control" placeholder="CVC">
                                                @error('card_cvc')
                                            <div class="invalid-feedback d-block mb-2">{{ $message }}</div>
                                        @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="border rounded p-3 position-relative" style="cursor: pointer;"
                                    onclick="selectPayment('blik')">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" id="pay_blik"
                                            value="blik" {{ old('payment_method') == 'blik' ? 'checked' : '' }}>
                                        <label class="form-check-label w-100 fw-bold" for="pay_blik">
                                            <img src="Blik_logo.jpg" alt="BLIK" style="height: 20px;" class="me-2">
                                            BLIK
                                        </label>
                                    </div>

                                    <div id="blik-details"
                                        class="mt-3 ps-4 {{ old('payment_method') == 'blik' ? '' : 'd-none' }}">
                                        <input type="text" name="blik_code"
                                            class="form-control text-center fs-5 @error('blik_code') is-invalid @enderror"
                                            placeholder="000 000" maxlength="6" style="letter-spacing: 3px;"
                                            value="{{ old('blik_code') }}">

                                        @error('blik_code')
                                            <div class="invalid-feedback d-block text-center">{{ $message }}</div>
                                        @enderror

                                        <small class="text-muted d-block text-center mt-1">Wpisz kod z aplikacji
                                            bankowej</small>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-dark w-100 py-3 fs-5 fw-bold shadow-sm"
                                style="background-color: #000; color: #fff;">
                                Zapłać i zamów
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="loading-overlay"
        class="d-none position-fixed top-0 start-0 w-100 h-100 bg-white bg-opacity-90 d-flex flex-column justify-content-center align-items-center"
        style="z-index: 9999;">
        <div class="spinner-border text-primary" style="width: 4rem; height: 4rem;" role="status"></div>
        <h3 class="mt-4 fw-bold">Przetwarzanie płatności...</h3>
        <p class="text-muted">Prosimy nie zamykać okna przeglądarki.</p>
    </div>

    <script>
        // 1. Переключение методов оплаты
        function selectPayment(method) {
            // Выбираем радио-кнопку
            document.getElementById('pay_' + method).checked = true;

            // Показываем нужные поля
            if (method === 'card') {
                document.getElementById('card-details').classList.remove('d-none');
                document.getElementById('blik-details').classList.add('d-none');
            } else {
                document.getElementById('card-details').classList.add('d-none');
                document.getElementById('blik-details').classList.remove('d-none');
            }
        }

        document.getElementById('payment-form').addEventListener('submit', function(e) {
            e.preventDefault();
            document.getElementById('loading-overlay').classList.remove('d-none');
            setTimeout(() => {
                e.target.submit();
            }, 2000);
        });

    </script>
@endsection
