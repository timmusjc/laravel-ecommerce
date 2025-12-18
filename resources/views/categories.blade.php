@extends('layout')

@section('title')
    Kategorie
@endsection

@section('main_content')



<div class="categories-page py-4 py-md-5">
    <div class="container categories-container">
        
        <!-- Заголовок -->
        <h1 class="page-title">Kategorie</h1>
        
        <!-- Сетка категорий -->
        <div class="categories-grid">
            @foreach ($categories as $category)
                <a href="{{ route('category', $category->slug) }}" class="category-card">
                    <!-- Изображение категории -->
                    <div class="category-image-wrapper">
                        <div class="category-image-inner">
                            @if($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" 
                                     alt="{{ $category->name }}"
                                     class="  category-image">
                            @else
                                <div class="no-image">
                                    <svg fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zM4 15h3v-5H4v5zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3zm3 0h-2v3h2v-3z"/>
                                    </svg>
                                    <span class="no-image-text">Brak zdjęcia</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Название категории -->
                    <div class="category-content">
                        <h2 class="category-name">{{ $category->name }}</h2>
                    </div>
                </a>
            @endforeach
        </div>
        
    </div>
</div>

@endsection