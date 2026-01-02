@extends('layout')

@section('title', 'Panel admina')

@section('main_content')
<div class="">
    <div class="card shadow-sm border-primary"> <div class="card-body">
            <h5 class="card-title text-primary">📦 Заказы</h5>
            <p class="card-text">Просмотр новых заказов.</p>
            <a href="{{ route('admin.orders') }}" class="btn btn-primary">Открыть заказы</a>
        </div>
    </div>
</div>

    @endsection