@extends('layout')

@section('title', 'Zarządzanie zamówieniami')

@section('main_content')
<div class="admin-orders-page">
    <div class="container admin-container">
        <div class="admin-header">
            <h1 class="admin-title">Zamówienia klientów</h1>
            <a href="{{ route('admin.index') }}" class="btn-back">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                </svg>
                Powrót do menu
            </a>
        </div>

        <div class="orders-table-card">
            <table class="orders-table table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Klient</th>
                        <th>Suma</th>
                        <th>Status</th>
                        <th>Data</th>
                        <th>Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr class="order-row">
                        <td class="order-id">#{{ $order->id }}</td>
                        <td class="order-customer">
                            {{ $order->user->name }}
                        </td>
                        <td class="order-price">
                            {{ number_format($order->total_price, 2, ',', ' ') }} zł
                        </td>
                        <td>
                            @if($order->status == 'new')
                                <span class="order-badge badge-new">Nowe</span>
                            @elseif($order->status == 'processing')
                                <span class="order-badge badge-processing">W realizacji</span>
                            @elseif($order->status == 'completed')
                                <span class="order-badge badge-completed">Zrealizowane</span>
                            @elseif($order->status == 'cancelled')
                                <span class="order-badge badge-cancelled">Anulowane</span>
                            @else
                                <span class="order-badge badge-default">{{ $order->status }}</span>
                            @endif
                        </td>
                        <td class="order-date">
                            <div class="date-main">{{ $order->created_at->format('d.m.Y') }}</div>
                            <div class="date-time">{{ $order->created_at->format('H:i') }}</div>
                        </td>
                        <td>
                            <button class="btn-details" type="button" 
                                    data-bs-toggle="collapse" 
                                    data-bs-target="#collapseOrder{{ $order->id }}" 
                                    aria-expanded="false">
                                Szczegóły
                                <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </button>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="6" class="p-0 border-0">
                            <div class="collapse order-details" id="collapseOrder{{ $order->id }}">
                                <div class="details-content">
                                    <!-- Данные доставки -->
                                    <div class="shipping-info-card">
                                        <h6 class="section-heading">Dane do wysyłki</h6>
                                        <div class="info-grid">
                                            <div class="info-row">
                                                <span class="info-label">Adres:</span>
                                                <span class="info-value">{{ $order->address }}</span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-label">Telefon:</span>
                                                <span class="info-value">{{ $order->phone }}</span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-label">Email:</span>
                                                <span class="info-value">{{ $order->user->email }}</span>
                                            </div>
                                        </div>
                                        @if($order->comment)
                                            <div class="comment-box">
                                                <div class="comment-label">Uwagi klienta:</div>
                                                <div class="comment-text">{{ $order->comment }}</div>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Товары -->
                                    <div class="products-section">
                                        <h6 class="section-heading">Zamówione produkty</h6>
                                        <table class="products-table table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Produkt</th>
                                                    <th class="text-center">Ilość</th>
                                                    <th class="text-end">Cena (szt.)</th>
                                                    <th class="text-end">Suma</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($order->items as $item)
                                                <tr>
                                                    <td>
                                                        @if($item->product)
                                                            {{ $item->product->name }}
                                                        @else
                                                            <span class="text-deleted">Produkt usunięty</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">{{ $item->quantity }}</td>
                                                    <td class="text-end">{{ number_format($item->price, 2, ',', ' ') }} zł</td>
                                                    <td class="text-end product-total">{{ number_format($item->price * $item->quantity, 2, ',', ' ') }} zł</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="pagination-wrapper">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection