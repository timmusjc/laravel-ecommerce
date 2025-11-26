@extends('layout')

@section('title')
    Kategorie
@endsection

@section('main_content')
<h1 class="text-center">Kategorie</h1>
    <div class="album py-5 bg-body-tertiary">
        <div class="container">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                        @foreach($categories as $category)
                        <div class="col">
                            <div class="card shadow-sm"> <a href="{{route('category', $category->slug)}}"><img src="{{ asset('storage/' .$category->image) }}"  alt="{{$category->name}}" class="bd-placeholder-img card-img-top img-fixed"></a>
                                <div class="card-body">
                                    <h2 class="text-center">{{$category->name}}</h2>
                                    <div class="d-flex justify-content-between align-items-center">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
        </div>
    </div>
@endsection