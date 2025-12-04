@extends('layout')

@section('title')
    {{ $product->name }}
@endsection

@section('main_content')

<div class="container py-5">
    <div class="row g-5"> <div class="col-lg-6">
            <div class="product-image-container text-center bg-light rounded-3 p-3 mb-4">
                 @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" 
                         class="img-fluid rounded shadow-sm" 
                         style="max-height: 500px; object-fit: contain;"
                         alt="{{ $product->name }}">
                @else
                    <div class="text-muted py-5">Brak zdjęcia</div>
                @endif
            </div>
        </div>

        <div class="col-lg-6">
            
            <h1 class="display-6 fw-bold text-dark mb-3">{{ $product->name }}</h1>

            <div class="d-flex align-items-center flex-wrap gap-4 mb-4 p-3 bg-light bg-opacity-50 rounded-3 border">
                <div class="text-success product-price">
                    {{ number_format($product->price, 2, ',', ' ') }} zł
                </div>
                
                <form action="{{ route('cart.add', $product) }}" method="POST" class="d-flex flex-grow-1">
                    @csrf
                    <button type="submit" class="btn btn-dark btn-lg flex-grow-1 border-0 shadow-lg position-relative overflow-hidden">
                        {{-- Твой кастомный эффект --}}
                    
                          
                            <div class="fw-bold text-uppercase">
                                <i class="bi bi-cart-plus me-2"></i> Dodaj do koszyka
                            </div>
                        
                    </button>
                </form>
            </div>

            <div class="mb-5">
                <h5 class="fw-bold mb-2">Opis produktu</h5>
                <p class="text-secondary lh-lg">
                    {{ $product->description }}
                </p>
            </div>

            <div class="product-specs">
                <h5 class="fw-bold mb-3">Specyfikacja</h5>
                
                <div class="bg-white rounded border px-3">
                    @foreach($product->attributes as $attribute)
                        <div class="spec-row d-flex justify-content-between align-items-center">
                            <span class="text-muted">{{ $attribute->name }}</span>
                            <span class="fw-semibold text-dark text-end">
                                {{ $attribute->pivot->value }}
                                @if($attribute->unit) 
                                    <small class="text-secondary ms-1">{{ $attribute->unit }}</small> 
                                @endif
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>
@endsection