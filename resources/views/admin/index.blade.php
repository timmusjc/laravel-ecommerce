@extends('layout')

@section('title', 'Zarządzanie zamówieniami')

@section('main_content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold">Wszystkie zamówienia</h1>
        
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="orders-list">
        @foreach($orders as $order)
        <div class="card border mb-3 shadow-sm rounded-3 overflow-hidden">
            
            <div class="card-header bg-white p-3">
                <div class="row align-items-center">
                    
                    <div class="col-md-4 d-flex align-items-center mb-2 mb-md-0 pointer" 
                         data-bs-toggle="collapse" 
                         data-bs-target="#order{{ $order->id }}" 
                         style="cursor: pointer;">
                        
                        <div class="me-3 position-relative">
                            @if($order->user->avatar)
                                <img src="{{ asset('storage/' . $order->user->avatar) }}" 
                                     class="rounded-circle border" width="45" height="45" style="object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center" 
                                     style="width: 45px; height: 45px; font-weight: bold;">
                                    {{ substr($order->user->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div>
                            <div class="fw-bold text-dark">{{ $order->user->name }}</div>
                            <div class="text-muted small">#{{ $order->id }} &bull; {{ $order->created_at->format('d.m.Y H:i') }}</div>
                        </div>
                    </div>

                    <div class="col-md-3 text-md-center mb-2 mb-md-0 pointer"
                         data-bs-toggle="collapse" 
                         data-bs-target="#order{{ $order->id }}"
                         style="cursor: pointer;">
                        <span class="fw-bold fs-5">{{ number_format($order->total_price, 2, ',', ' ') }} zł</span>
                    </div>

                    <div class="col-md-5">
                        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="d-flex gap-2 justify-content-md-end">
                            @csrf
                            @method('PATCH')
                            
                            <select name="status" class="form-select form-select-sm fw-bold border-{{ $order->status == 'new' ? 'primary' : ($order->status == 'completed' ? 'success' : 'secondary') }}" 
                                    style="max-width: 200px;" 
                                    onchange="this.form.submit()">
                                <option value="new" {{ $order->status == 'new' ? 'selected' : '' }}>🔵 Nowe</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>🟠 W trakcie</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>🟢 Zrealizowane</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>⚫ Anulowane</option>
                            </select>
                            
                            
                        </form>
                    </div>
                </div>
            </div>

            <div id="order{{ $order->id }}" class="collapse">
                <div class="card-body bg-light">
                    
                    <div class="row">
                        <div class="col-md-4 border-end-md mb-3">
                            <h6 class="text-uppercase text-muted small fw-bold mb-3">Dane klienta</h6>
                            <ul class="list-unstyled small">
                                <li class="mb-2"><i class="bi bi-envelope me-2"></i> {{ $order->user->email }}</li>
                                <li class="mb-2"><i class="bi bi-telephone me-2"></i> {{ $order->phone }}</li>
                                <li class="mb-2"><i class="bi bi-geo-alt me-2"></i> {{ $order->address }}</li>
                                @if($order->comment)
                                    <li class="mt-3 p-2 bg-white rounded border">
                                        <em>"{{ $order->comment }}"</em>
                                    </li>
                                @endif
                            </ul>
                        </div>

                        <div class="col-md-8">
                            <h6 class="text-uppercase text-muted small fw-bold mb-3">Zawartość zamówienia</h6>
                            <div class="d-flex flex-column gap-2">
                                @foreach($order->items as $item)
                                <div class="d-flex align-items-center bg-white p-2 rounded border">
                                    <div style="width: 40px; height: 40px;" class="me-3 flex-shrink-0">
                                        @if($item->product && $item->product->image)
                                            <img src="{{ asset('storage/'.$item->product->image) }}" class="w-100 h-100 object-fit-contain">
                                        @else
                                            <div class="w-100 h-100 bg-secondary d-flex align-items-center justify-content-center text-white small">?</div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-medium small">
                                            {{ $item->product ? $item->product->name : 'Produkt usunięty' }}
                                        </div>
                                    </div>
                                    <div class="text-end ms-3">
                                        <div class="small text-muted">{{ $item->quantity }} szt.</div>
                                        <div class="fw-bold small">{{ number_format($item->price, 2) }} zł</div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $orders->links() }}
    </div>
</div>
@endsection