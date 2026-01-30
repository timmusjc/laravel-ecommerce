@extends('layout')

@section('title', 'Nowa kategoria')

@section('main_content')
<div class="categories-page py-4 py-md-5">
    <div class="container categories-container" style="max-width: 900px;">

        <h1 class="page-title mb-4">Dodaj nową kategorię</h1>

        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="category-card">

                {{-- IMAGE --}}
                <div class="category-image-wrapper">
                    <div class="category-image-inner">

                        <div id="imagePlaceholder" class="no-image" style="cursor:pointer"
                             onclick="document.getElementById('imageInput').click()">
                            <svg fill="currentColor" viewBox="0 0 16 16">
                                <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0"/>
                                <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12"/>
                            </svg>
                            <span class="no-image-text">Kliknij, aby dodać zdjęcie</span>
                        </div>

                        <img id="imagePreview" class="category-image" style="display:none;">
                    </div>
                </div>

                <input type="file"
                       name="image"
                       id="imageInput"
                       class="d-none"
                       accept="image/*"
                       onchange="previewCategoryImage(this)">

                {{-- CONTENT --}}
                <div class="category-content">
                    <input type="text"
                           name="name"
                           class="form-control"
                           placeholder="Nazwa kategorii"
                           required
                           style="font-size:1.25rem; text-align:center;">
                </div>
            </div>

            {{-- ACTIONS --}}
            <div class="position-fixed bottom-0 end-0 p-4 d-flex gap-2" style="z-index:1000;">
                <a href="{{ route('categories') }}" class="btn btn-secondary shadow-sm">
                    Anuluj
                </a>
                <button type="submit" class="btn btn-success shadow-sm">
                    Zapisz kategorię
                </button>
            </div>

        </form>
    </div>
</div>

<script>
function previewCategoryImage(input){
    if(!input.files || !input.files[0]) return;

    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('imagePreview').src = e.target.result;
        document.getElementById('imagePreview').style.display = 'block';
        document.getElementById('imagePlaceholder').style.display = 'none';
    };
    reader.readAsDataURL(input.files[0]);
}
</script>
@endsection
