@extends('layout')

@section('title')
    Kategorie
@endsection

@section('main_content')
    <div class="categories-page py-4 py-md-5">
        <div class="container categories-container">

            <h1 class="page-title">Kategorie</h1>

            <div class="categories-grid">

                {{-- ADMIN: add new category card --}}
                @auth
                    @if(auth()->user()->is_admin)
                        <div class="category-card category-add-card position-relative">
                            <a href="{{ route('admin.categories.create') }}" class="stretched-link" aria-label="Dodaj kategorię"></a>

                            <div class="category-image-wrapper">
                                <div class="category-image-inner">
                                    <div class="no-image">
                                        <svg width="48" height="48" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                                            <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z" />
                                        </svg>
                                        <span class="no-image-text">Dodaj kategorię</span>
                                    </div>
                                </div>
                            </div>

                            <div class="category-content">
                                <h2 class="category-name">Dodaj nową kategorię</h2>
                            </div>
                        </div>
                    @endif
                @endauth

                {{-- categories list --}}
                @foreach ($categories as $category)
                    <div class="category-card position-relative">

                        {{-- ADMIN controls (same vibe as products page) --}}
                        @auth
                            @if(auth()->user()->is_admin)
                                <div class="admin-controls">
                                    <a href="{{ route('admin.categories.edit', $category) }}"
                                       class="btn-admin-edit"
                                       title="Edytuj"
                                       aria-label="Edytuj">
                                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path
                                                d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                        </svg>
                                    </a>

                                    <form action="{{ route('admin.categories.destroy', $category) }}"
                                          method="POST"
                                          onsubmit="return confirm('Czy na pewno chcesz usunąć tę kategorię?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-admin-delete" title="Usuń" aria-label="Usuń">
                                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                <path
                                                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                <path fill-rule="evenodd"
                                                    d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endauth

                        {{-- Whole card clickable (except admin buttons) --}}
                        <a href="{{ route('category', $category->slug) }}" class="stretched-link" aria-label="{{ $category->name }}"></a>

                        <div class="category-image-wrapper">
                            <div class="category-image-inner">
                                @if ($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}"
                                         alt="{{ $category->name }}"
                                         class="category-image">
                                @else
                                    <div class="no-image">
                                        <svg fill="currentColor" viewBox="0 0 16 16">
                                            <path
                                                d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zM4 15h3v-5H4v5zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3zm3 0h-2v3h2v-3z" />
                                        </svg>
                                        <span class="no-image-text">Brak zdjęcia</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="category-content">
                            <h2 class="category-name">{{ $category->name }}</h2>
                        </div>

                    </div>
                @endforeach

            </div>

        </div>
    </div>
@endsection
