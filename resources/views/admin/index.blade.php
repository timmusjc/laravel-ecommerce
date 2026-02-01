@extends('layout')

@section('title', 'Panel Administratora')

@section('main_content')
<div class="container py-5">
    <h1 class="mb-4 fw-bold">Panel Administratora</h1>

    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-primary text-white h-100">
                <div class="card-body">
                    <h6 class="text-uppercase mb-2 opacity-75">Zamówienia</h6>
                    <h2 class="fw-bold">{{ $stats['orders_count'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-success text-white h-100">
                <div class="card-body">
                    <h6 class="text-uppercase mb-2 opacity-75">Przychód (opłacone)</h6>
                    <h2 class="fw-bold">{{ number_format($stats['revenue'], 2, ',', ' ') }} zł</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-info text-white h-100">
                <div class="card-body">
                    <h6 class="text-uppercase mb-2 opacity-75">Użytkownicy</h6>
                    <h2 class="fw-bold">{{ $stats['users_count'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-warning text-dark h-100">
                <div class="card-body">
                    <h6 class="text-uppercase mb-2 opacity-75">Produkty</h6>
                    <h2 class="fw-bold">{{ $stats['products_count'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <h3 class="mb-4">Zarządzanie sklepem</h3>

    <div class="row g-4">
        
        <div class="col-md-4">
            <a href="{{ route('admin.orders') }}" class="text-decoration-none">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="card-body text-center py-5">
                        <div class="mb-3 text-primary">
                            <i class="bi bi-basket3-fill fs-1"></i>
                        </div>
                        <h5 class="card-title text-dark fw-bold">Zamówienia</h5>
                        <p class="text-muted small">Przeglądaj i zmieniaj statusy zamówień</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('admin.users') }}" class="text-decoration-none">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="card-body text-center py-5">
                        <div class="mb-3 text-info">
                            <i class="bi bi-people-fill fs-1"></i>
                        </div>
                        <h5 class="card-title text-dark fw-bold">Użytkownicy</h5>
                        <p class="text-muted small">Zarządzaj kontami klientów i administratorów</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('admin.products.create') }}" class="text-decoration-none">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="card-body text-center py-5">
                        <div class="mb-3 text-success">
                            <i class="bi bi-plus-circle-fill fs-1"></i>
                        </div>
                        <h5 class="card-title text-dark fw-bold">Dodaj produkt</h5>
                        <p class="text-muted small">Wprowadź nowy asortyment do sklepu</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('admin.categories.create') }}" class="text-decoration-none">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="card-body text-center py-5">
                        <div class="mb-3 text-success">
                            <i class="bi bi-plus-circle-fill fs-1"></i>
                        </div>
                        <h5 class="card-title text-dark fw-bold">Dodaj kategorię</h5>
                        <p class="text-muted small">Wprowadź nową kategorię produktów</p>
                    </div>
                </div>
            </a>
        </div>

    </div>
</div>

<style>
    /* Эффект при наведении на карточку */
    .hover-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    .border-dashed {
        border: 2px dashed #dee2e6 !important;
    }
</style>
@endsection