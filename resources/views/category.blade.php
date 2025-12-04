@extends('layout')

@section('title')
    {{$category->name}}
@endsection

@section('main_content')

<h1 class="text-center">{{$category->name}}</h1>
<div class="album py-5 bg-body-tertiary">
    
    <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                @foreach ($products as $product)
                    <div class="col">
                        <div class="card shadow-sm"> <a href="{{ route('product', $product->slug) }}"><img
                                    src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="bd-placeholder-img card-img-top img-fixed"></a>
                            <div class="card-body">
                                <h3 class="card-text">{{ $product->name }}</h3>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="text-success">{{ $product->price }} zł</h4>
                                </div>


                                <div class="d-flex justify-content-end">
                                    <form action="{{ route('cart.add', $product) }}" method="POST">
                                        <button type="submit">
                                            <div class="liquidGlass-wrapper button">
                                                <div class="liquidGlass-effect"></div>
                                                <div class="liquidGlass-tint"></div>
                                                <div class="liquidGlass-shine"></div>
                                                <div class="liquidGlass-text">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        fill="currentColor" class="bi bi-cart-plus-fill"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0M9 5.5V7h1.5a.5.5 0 0 1 0 1H9v1.5a.5.5 0 0 1-1 0V8H6.5a.5.5 0 0 1 0-1H8V5.5a.5.5 0 0 1 1 0" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </button>
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
</div>
@endsection
