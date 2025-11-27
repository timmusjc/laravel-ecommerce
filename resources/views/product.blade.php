@extends('layout')

@section('title')
    {{ $product->name }}
@endsection

@section('main_content')
    <div class="container mt-5">

        <div class="row justify-content-center">

            <!-- Левая колонка: фото -->
            <div class="col-md-5 text-center">
                <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded shadow-sm img-fixed"
                    alt="{{ $product->name }}">
            </div>

            <!-- Правая колонка: инфо -->
            <div class="col-md-5">

                <h1 class="mb-3">{{ $product->name }}</h1>

                <h3 class="text-muted">
                    {{ $product->description }}
                </h3>

                <h2 class="text-success mb-4">
                    {{ $product->price }} zł
                </h2>

                <a href="#">
                    <div class="liquidGlass-wrapper button">
                        <div class="liquidGlass-effect"></div>
                        <div class="liquidGlass-tint"></div>
                        <div class="liquidGlass-shine"></div>
                        <div class="liquidGlass-text">
                            Dodaj do koszyka
                        </div>
                    </div>
                </a>
            </div>

            {{-- <button class="btn btn-primary btn-lg w-100">
                Dodaj do koszyka
            </button> --}}

        </div>

    </div>

    </div>
@endsection
