@extends('layout')

@section('title')
    {{$category->name}}
@endsection

@section('main_content')

<h1 class="text-center">{{$category->name}}</h1>
<div class="album py-5 bg-body-tertiary">
    
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            @foreach($products as $product)
                <div class="col">
                    <div class="card shadow-sm"> <a href="{{route('product', $product->slug)}}"><img src="{{ asset('storage/' .$product->image) }}" alt="{{$product->name}}" class="bd-placeholder-img card-img-top img-fixed"></a>
                        <div class="card-body">
                            <h3 class="card-text">{{$product->name}}</h3>
                            <div class="d-flex justify-content-between align-items-center">
                                 <h4 class="text-success">{{$product->price}} zł</h4>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

        </div>
    </div>
</div>
@endsection
