@extends('layout')

@section('main_content')
    <div class="container py-5 text-center">
        <div class="card shadow border-0 mx-auto" style="max-width: 600px;">
            <div class="card-body p-5">
                <div class="mb-4 text-success">
                    <i class="bi bi-check-circle-fill" style="font-size: 4rem;"></i>
                </div>
                <h2 class="mb-3 fw-bold">Dziękujemy za złożenie zamówienia!</h2>
                <p class="text-muted mb-4">
                    Twoje zamówienie nr <strong>#{{ $order->id }}</strong> zostało przyjęte do realizacji.
                </p>

                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                    <a href="{{ route('order_pdf', $order) }}" class="btn btn-outline-dark px-4 gap-3">
                        <i class="bi bi-file-earmark-pdf"></i> Pobierz fakturę
                    </a>

                    <a href="{{ route('home') }}" class="btn btn-primary px-4">
                        Wróć do sklepu
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
