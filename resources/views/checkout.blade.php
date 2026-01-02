@extends('layout')

@section('title')
    Złożenie zamówienia
@endsection

@section('main_content')
<div class="checkout-page">
    <div class="container cart-page checkout-container">
        <h1 class="cart-title">Złożenie zamówienia</h1>
        
        <div class="checkout-layout">
            <!-- Правая колонка - Корзина -->
            <div class="checkout-summary-col">
                <div class="checkout-summary">
                    <h3 class="summary-title">Twój koszyk</h3>
                    
                    <div class="summary-items">
                        @foreach($cart as $item)
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
            
            <!-- Левая колонка - Форма -->
            <div class="checkout-form-col">
                <div class="checkout-form-card">
                    <h3 class="form-section-title">Dane dostawy</h3>
                    
                    <form action="{{ route('order.store') }}" method="POST" class="checkout-form">
                        @csrf
                        
                        <div class="form-group">
                            <label for="address" class="form-label">Adres dostawy</label>
                            <input type="text" 
                                   id="address"
                                   class="form-input" 
                                   name="address" 
                                   required 
                                   placeholder="Warszawa, ul. Złota 44">
                        </div>
                        
                        <div class="form-group">
                            <label for="phone" class="form-label">Numer telefonu</label>
                            <input type="tel" 
                                   id="phone"
                                   class="form-input" 
                                   name="phone" 
                                   required 
                                   placeholder="+48 123 456 789">
                        </div>
                        
                        <div class="form-group">
                            <label for="comment" class="form-label">Uwagi do zamówienia (opcjonalnie)</label>
                            <textarea id="comment"
                                      class="form-textarea" 
                                      name="comment"
                                      rows="3"
                                      placeholder="Dodatkowe informacje..."></textarea>
                        </div>
                        
                        <button type="submit" class="btn-checkout-submit">
                            Złóż zamówienie
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection