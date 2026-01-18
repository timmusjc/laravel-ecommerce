@extends('layout')

@section('title', 'Mój Profil')

@section('main_content')
    <div class="profile-page">
        <div class="container profile-container">

            <!-- Алерты -->
            @if (session('success'))
                <div class="profile-alert alert-success">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                    </svg>
                    {{ session('success') }}
                    <button class="alert-close" onclick="this.parentElement.remove()">×</button>
                </div>
            @endif

            @if (session('error'))
                <div class="profile-alert alert-error">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                    </svg>
                    {{ session('error') }}
                    <button class="alert-close" onclick="this.parentElement.remove()">×</button>
                </div>
            @endif

            @if ($errors->any())
                <div class="profile-alert alert-error">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                    </svg>
                    <div>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                    <button class="alert-close" onclick="this.parentElement.remove()">×</button>
                </div>
            @endif

            <div class="profile-layout">

                <!-- Левая колонка - Карточка профиля -->
                <div class="profile-sidebar">
                    <div class="profile-card">
                        <!-- Форма с аватаром и именем -->
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Аватар -->
                            <div class="profile-avatar-wrapper">
                                <label for="avatarInput" class="avatar-label">
                                    @if ($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}" id="avatarPreview"
                                            class="profile-avatar" alt="Avatar">
                                    @else
                                        <div id="avatarPlaceholder" class="profile-avatar-placeholder">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <img id="avatarPreview" class="profile-avatar" style="display: none;"
                                            src="">
                                    @endif
                                    <div class="avatar-overlay">
                                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                                            <path
                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                            <path fill-rule="evenodd"
                                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                        </svg>
                                    </div>
                                </label>
                                <input type="file" id="avatarInput" name="avatar" accept="image/*"
                                    style="display: none;">
                            </div>

                            <!-- Информация -->
                            <div class="profile-info">
                                <h2 class="profile-name">{{ $user->name }}</h2>
                                <p class="profile-email">{{ $user->email }}</p>
                                <div class="profile-meta">
                                    <span class="meta-label">Rejestracja:</span>
                                    <span class="meta-value">{{ $user->created_at->format('d.m.Y') }}</span>
                                </div>
                            </div>

                            <!-- Редактирование имени -->
                            <div class="profile-section">
                                <h3 class="section-heading">Dane osobowe</h3>
                                <div class="form-group">
                                    <label class="form-label">Imię</label>
                                    <input type="text" name="name" class="form-input" value="{{ $user->name }}"
                                        required>
                                </div>
                                <button type="submit" class="btn-save">Zapisz zmiany</button>
                            </div>
                        </form>

                        <!-- Форма смены пароля -->
                        <form action="{{ route('profile.password') }}" method="POST" class="profile-section">
                            @csrf
                            <h3 class="section-heading section-heading-danger">Zmiana hasła</h3>

                            <div class="form-group">
                                <label class="form-label">Obecne hasło</label>
                                <input type="password" name="current_password"
                                    class="form-input @error('current_password') is-invalid @enderror" required>
                                @error('current_password')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Nowe hasło</label>
                                <input type="password" name="password"
                                    class="form-input @error('password') is-invalid @enderror" required minlength="8">
                                @error('password')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Powtórz nowe hasło</label>
                                <input type="password" name="password_confirmation" class="form-input" required
                                    minlength="8">
                            </div>

                            <button type="submit" class="btn-save btn-save-danger">Zmień hasło</button>
                        </form>
                    </div>
                </div>

                <!-- Правая колонка - История заказов -->
                <div class="profile-main">
                    <div class="profile-tabs-card">
                        <h2 class="orders-title">Historia zamówień</h2>

                        @if ($orders->count() > 0)
                            <div class="orders-list">
                                @foreach ($orders as $order)
                                    <div class="order-card">
                                        <div class="order-header">
                                            <button class="order-toggle" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#order{{ $order->id }}">
                                                <div class="order-header-left">
                                                    <span class="order-number">Zamówienie #{{ $order->id }}</span>
                                                    <span
                                                        class="order-date">{{ $order->created_at->format('d.m.Y H:i') }}</span>
                                                </div>
                                                <div class="order-header-right">
                                                    <!-- Статус заказа -->
                                                    <span class="order-status order-status-{{ $order->status }}">
                                                        @switch($order->status)
                                                            @case('new')
                                                                <svg class="status-icon" fill="currentColor" viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                                                </svg>
                                                                Nowe
                                                            @break

                                                            @case('processing')
                                                                <svg class="status-icon" fill="currentColor" viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.95.313a7.023 7.023 0 0 0-.179-.483zm.53 2.507a6.991 6.991 0 0 0-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1 .025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 0 1-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535zm-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 0 1-.401.432l-.707-.707z" />
                                                                    <path
                                                                        d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0v1z" />
                                                                    <path
                                                                        d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z" />
                                                                </svg>
                                                                W trakcie
                                                            @break

                                                            @case('completed')
                                                                <svg class="status-icon" fill="currentColor" viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                                                </svg>
                                                                Zrealizowane
                                                            @break

                                                            @case('cancelled')
                                                                <svg class="status-icon" fill="currentColor" viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                                                                </svg>
                                                                Anulowane
                                                            @break
                                                        @endswitch
                                                    </span>
                                                    <span
                                                        class="order-total">{{ number_format($order->total_price, 2, ',', ' ') }}
                                                        zł</span>
                                                    <svg class="order-arrow" fill="currentColor" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd"
                                                            d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                                                    </svg>
                                                </div>
                                            </button>
                                        </div>

                                        <div id="order{{ $order->id }}" class="collapse order-details">
                                            <div class="order-items">
                                                @foreach ($order->items as $item)
                                                    <div class="order-item">
                                                        @if ($item->product)
                                                            <!-- Если товар существует - делаем ссылку -->
                                                            <a href="{{ route('product', $item->product->slug) }}"
                                                                class="item-image">
                                                                @if ($item->product->image)
                                                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                                                        alt="{{ $item->product->name }}">
                                                                @else
                                                                    <div class="item-placeholder">
                                                                        <svg width="24" height="24"
                                                                            fill="currentColor" viewBox="0 0 16 16">
                                                                            <path
                                                                                d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                                                                            <path
                                                                                d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z" />
                                                                        </svg>
                                                                    </div>
                                                                @endif
                                                            </a>
                                                        @else
                                                            <!-- Если товар удален - без ссылки -->
                                                            <div class="item-image">
                                                                <div class="item-placeholder">
                                                                    <svg width="24" height="24"
                                                                        fill="currentColor" viewBox="0 0 16 16">
                                                                        <path
                                                                            d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                                                                        <path
                                                                            d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z" />
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        <div class="item-info">
                                                            @if ($item->product)
                                                                <a href="{{ route('product', $item->product->slug) }}"
                                                                    class="item-name item-name-link">
                                                                    {{ $item->product->name }}
                                                                </a>
                                                            @else
                                                                <div class="item-name item-name-deleted">
                                                                    Produkt usunięty
                                                                </div>
                                                            @endif
                                                            <div class="item-quantity">Ilość: {{ $item->quantity }}</div>
                                                        </div>
                                                        <div class="item-price">
                                                            {{ number_format($item->price * $item->quantity, 2, ',', ' ') }}
                                                            zł
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class="order-address">
                                                <span class="address-label">Adres dostawy:</span>
                                                <span class="address-value">{{ $order->address }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <svg class="empty-icon" fill="currentColor" viewBox="0 0 16 16">
                                    <path
                                        d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                </svg>
                                <h3 class="empty-title">Brak zamówień</h3>
                                <p class="empty-text">Nie masz jeszcze żadnych zamówień</p>
                                <a href="{{ route('home') }}" class="btn-shop">Przejdź do produktów</a>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>


@endsection

<style>
    /* Стили для статусов заказов */
    .order-status {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-size: 0.8125rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .status-icon {
        width: 14px;
        height: 14px;
        flex-shrink: 0;
    }

    /* Новый заказ - синий */
    .order-status-new {
        background-color: #dbeafe;
        color: #1e40af;
    }

    /* В процессе - оранжевый */
    .order-status-processing {
        background-color: #fed7aa;
        color: #c2410c;
    }

    /* Выполнен - зеленый */
    .order-status-completed {
        background-color: #d1fae5;
        color: #065f46;
    }

    /* Отменен - серый */
    .order-status-cancelled {
        background-color: #e5e7eb;
        color: #374151;
    }

    /* Адаптация order-header-right для размещения статуса */
    .order-header-right {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    /* Адаптивность */
    @media (max-width: 768px) {
        .order-header-right {
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .order-status {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }

        .status-icon {
            width: 12px;
            height: 12px;
        }

        .order-total {
            order: -1;
            width: 100%;
            margin-bottom: 0.25rem;
        }
    }

    @media (max-width: 576px) {

        .order-header-left,
        .order-header-right {
            width: 100%;
        }

        .order-header-right {
            margin-top: 0.5rem;
            justify-content: space-between;
        }
    }
</style>
