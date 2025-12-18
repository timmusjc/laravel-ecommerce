@extends('layout')

@section('title')
    {{ $product->name }}
@endsection

@section('main_content')

<style>
    /* Общие стили */
    .product-page {
        max-width: 1400px;
        margin: 0 auto;
    }
    
    /* Контейнер изображения */
    .product-image-wrapper {
        position: relative;
        width: 100%;
        padding-bottom: 100%; /* Квадратное соотношение 1:1 */
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .product-image-inner {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    
    .product-image-wrapper img {
        max-width: 100%;
        max-height: 100%;
        width: auto;
        height: auto;
        object-fit: contain;
    }
    
    /* Основная информация */
    .product-info {
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    
    .product-title {
        font-size: 1.75rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 1rem;
        line-height: 1.3;
    }
    
    .product-price {
        font-size: 2rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 2rem;
    }
    
    /* Кнопка добавления в корзину */
    .btn-add-to-cart {
        background-color: #111827;
        color: white;
        padding: 1rem 2rem;
        font-size: 1rem;
        font-weight: 600;
        border: none;
        border-radius: 6px;
        transition: background-color 0.2s ease;
        width: 100%;
        max-width: 400px;
    }
    
    .btn-add-to-cart:hover {
        background-color: #1f2937;
        color: white;
    }
    
    .btn-add-to-cart:active {
        background-color: #374151;
    }
    
    /* Секция описания */
    .product-description {
        background-color: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 1.5rem;
        margin-top: 2rem;
    }
    
    .section-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 1rem;
    }
    
    .description-text {
        color: #4b5563;
        line-height: 1.6;
        margin: 0;
    }
    
    /* Таблица спецификаций */
    .specifications {
        margin-top: 2rem;
    }
    
    .spec-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .spec-row {
        border-bottom: 1px solid #e5e7eb;
    }
    
    .spec-row:last-child {
        border-bottom: none;
    }
    
    .spec-label {
        padding: 1rem 1.25rem;
        font-weight: 500;
        color: #6b7280;
        width: 40%;
        background-color: #f9fafb;
    }
    
    .spec-value {
        padding: 1rem 1.25rem;
        color: #111827;
        font-weight: 500;
    }
    
    /* Адаптивность */
    @media (max-width: 991px) {
        .product-title {
            font-size: 1.5rem;
        }
        
        .product-price {
            font-size: 1.75rem;
        }
        
        .btn-add-to-cart {
            max-width: 100%;
        }
    }
    
    @media (max-width: 575px) {
        .spec-label,
        .spec-value {
            display: block;
            width: 100%;
            padding: 0.75rem 1rem;
        }
        
        .spec-label {
            padding-bottom: 0.25rem;
            border-bottom: none;
        }
        
        .spec-value {
            padding-top: 0.25rem;
            background-color: white;
        }
    }
    
    /* Изображение - заглушка */
    .no-image {
        color: #9ca3af;
        font-size: 1rem;
    }
</style>

<div class="container product-page py-4 py-md-5">
    <div class="row g-4 g-lg-5">
        
        <!-- Левая колонка - Изображение -->
        <div class="col-lg-6">
            <div class="product-image-wrapper">
                <div class="product-image-inner">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             alt="{{ $product->name }}">
                    @else
                        <div class="no-image text-center">
                            <svg width="64" height="64" fill="currentColor" viewBox="0 0 16 16" class="mb-2">
                                <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z"/>
                            </svg>
                            <div>Brak zdjęcia</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Правая колонка - Информация -->
        <div class="col-lg-6">
            <div class="product-info">
                
                <!-- Название товара -->
                <h1 class="product-title">{{ $product->name }}</h1>
                
                <!-- Цена -->
                <div class="product-price">
                    {{ number_format($product->price, 2, ',', ' ') }} zł
                </div>
                
                <!-- Кнопка добавления в корзину -->
                <form action="{{ route('cart.add', $product) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-dark btn-lg border-0 shadow-lg position-relative overflow-hidden">
                        
                    
                          
                            <div class="fw-bold text-uppercase">
                                <i class="bi bi-cart-plus me-2"></i> Dodaj do koszyka
                            </div>
                        
                    </button>
                </form>
                
                <!-- Описание товара -->
                <div class="product-description">
                    <h2 class="section-title">Opis produktu</h2>
                    <p class="description-text">{{ $product->description }}</p>
                </div>
                
                <!-- Спецификация -->
                @if($product->attributes->count() > 0)
                <div class="specifications">
                    <h2 class="section-title">Specyfikacja techniczna</h2>
                    <table class="spec-table">
                        @foreach($product->attributes as $attribute)
                        <tr class="spec-row">
                            <td class="spec-label">{{ $attribute->name }}</td>
                            <td class="spec-value">
                                {{ $attribute->pivot->value }}
                                @if($attribute->unit)
                                    {{ $attribute->unit }}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                @endif
                
            </div>
        </div>
        
    </div>
</div>

@endsection