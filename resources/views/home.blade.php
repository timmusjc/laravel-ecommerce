@extends('layout')

@section('title')
    Sklepik u Tima
@endsection

@section('main_content')
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


                               <div class="d-flex justify-content-end"> <button>
                                        <div class="liquidGlass-wrapper button">
                                        <div class="liquidGlass-effect"></div>
                                        <div class="liquidGlass-tint"></div>
                                        <div class="liquidGlass-shine"></div>
                                        <div class="liquidGlass-text">
                                            Dodaj do koszyka
                                        </div>
                                    </div>
                                    </div></button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
