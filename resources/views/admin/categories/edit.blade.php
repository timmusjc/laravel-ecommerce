@extends('layout')

@section('title', 'Edycja kategorii')

@section('main_content')
    <div class="categories-page py-4 py-md-5">
        <div class="container categories-container u-max-width-900">

            <h1 class="page-title mb-4">Edytuj kategorię</h1>

            <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="category-card">

                    <div class="category-image-wrapper">
                        <div class="category-image-inner">

                            <label for="imageInput" class="category-image-label">

                                @if ($category->image)
                                    <img id="imagePreview" src="{{ asset('storage/' . $category->image) }}"
                                        class="category-image">
                                @else
                                    <div id="imagePlaceholder" class="no-image">
                                        <svg fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0" />
                                            <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12" />
                                        </svg>
                                        <span class="no-image-text">Kliknij, aby dodać zdjęcie</span>
                                    </div>

                                    <img id="imagePreview" class="category-image u-display-none">
                                @endif

                            </label>

                        </div>
                    </div>

                    <input type="file" name="image" id="imageInput" class="d-none" accept="image/*"
                        onchange="previewCategoryImage(this)">

                    <div class="category-content">
                        <input type="text" name="name" value="{{ $category->name }}"
                            class="form-control u-font-size-125 u-text-center" required>
                    </div>
                </div>

                <div class="position-fixed bottom-0 end-0 p-4 d-flex gap-2 u-z-1000">
                    <a href="{{ route('categories') }}" class="btn btn-secondary shadow-sm">
                        Anuluj
                    </a>
                    <button type="submit" class="btn btn-success shadow-sm">
                        Zapisz zmiany
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        function previewCategoryImage(input) {
            if (!input.files || !input.files[0]) return;

            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('imagePreview').src = e.target.result;
                document.getElementById('imagePreview').style.display = 'block';

                const ph = document.getElementById('imagePlaceholder');
                if (ph) ph.style.display = 'none';
            };
            reader.readAsDataURL(input.files[0]);
        }
    </script>
@endsection
