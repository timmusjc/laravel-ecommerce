@extends('layout')

@section('title') Koszyk @endsection

@section('main_content')
<div class="container py-5">
    <h2 class="mb-4">Koszyk</h2>

    @php $total = 0; @endphp

    @if(session('cart'))
        @foreach($cart as $productId => $product)
            @php 
                $total += $product['price'] * $product['quantity']; 
            @endphp
            
            {{-- Добавляем ID строки, чтобы можно было удалить её визуально (опционально) --}}
            <div class="row mb-3 border-bottom pb-3" data-id="{{ $productId }}">
                <div class="col-md-2">
                    <a href="{{ route('product', $product['slug'])}}">
                        <img src="{{ asset('storage/' . $product['image']) }}" class="img-fluid" alt="{{$product['name']}}">
                    </a>
                </div>
                <div class="col-md-4 d-flex align-items-center">
                    <a href="{{ route('product', $product['slug']) }}">
                        <h5>{{$product['name']}}</h5>
                    </a>
                </div>
                <div class="col-md-2 d-flex align-items-center">
                    {{-- 
                        ВАЖНО: 
                        1. class="update-cart" — для поиска через JS
                        2. data-id — хранит ID товара
                    --}}
                    <input type="number" 
                           value="{{ $product['quantity'] }}" 
                           min="1" 
                           class="form-control update-cart" 
                           data-id="{{ $productId }}">
                </div>
                <div class="col-md-2 d-flex align-items-center">
                    <strong>{{ $product['price'] }} zł</strong>
                </div>
                <div class="col-md-2 d-flex align-items-center">
                    <form action="{{ route('cart.remove', $productId) }}" method="POST">
                        @csrf
                        <button class="btn btn-danger btn-sm">Usuń</button>
                    </form>
                </div>
            </div>
        @endforeach
    @else
        <div class="alert alert-info">Twój koszyk jest pusty.</div>
    @endif

    <div class="text-end mt-4">
        {{-- Добавили ID="total-price", чтобы JS мог менять цифру внутри --}}
        <h4>Suma: <span class="text-success" id="total-price">{{ $total }}</span> <span class="text-success">zł</span></h4>
        <button class="btn btn-primary btn-lg mt-3">Przejdź do zamówienia</button>
    </div>
</div>

{{-- Скрипт для обработки изменений --}}
<script type="text/javascript">
    // Находим все инпуты с классом .update-cart
    document.querySelectorAll('.update-cart').forEach(function(element) {
        // Следим за изменением (событие change срабатывает, когда убираешь фокус с поля или жмешь Enter)
        // Можно использовать 'input', если хочешь мгновенной реакции при клике на стрелочки
        element.addEventListener('change', function (e) {
            e.preventDefault();

            let ele = this;
            let id = ele.getAttribute('data-id');
            let quantity = ele.value;

            // Если ввели меньше 1, сбрасываем на 1 (или можно вызывать удаление)
            if(quantity < 1) {
                ele.value = 1;
                quantity = 1;
            }

            // Отправляем запрос на сервер
            fetch('{{ route('cart.update') }}', {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Обязательно передаем CSRF токен
                },
                body: JSON.stringify({
                    id: id,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    // Обновляем общую сумму на странице
                    document.getElementById('total-price').innerText = data.total;
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
</script>

@endsection