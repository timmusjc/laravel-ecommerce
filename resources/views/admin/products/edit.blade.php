@extends('layout')

@section('title', 'Edycja: ' . $product->name)

@section('main_content')

<style>
/* ===================================
   КАРУСЕЛЬ НА СТРАНИЦЕ ТОВАРА
   =================================== */

.product-carousel-wrapper {
    width: 100%;
}

/* Контейнер карусели */
.carousel {
    position: relative;
    width: 100%;
    padding-bottom: 100%; /* Квадратное соотношение 1:1 */
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    overflow: hidden;
    margin-bottom: 1rem;
}

.carousel-inner {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}

.carousel-item {
    height: 100%;
}

.carousel-image-container {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    position: relative;
}

.carousel-image-container img {
    max-width: 100%;
    max-height: 100%;
    width: auto;
    height: auto;
    object-fit: contain;
}

/* Одиночное фото (без карусели) */
.product-single-image {
    position: relative;
    width: 100%;
    padding-bottom: 100%;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    overflow: hidden;
}

.product-single-image .carousel-image-container {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}

/* Стрелки карусели */
.carousel-control-prev,
.carousel-control-next {
    width: 40px;
    height: 40px;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(17, 24, 39, 0.7);
    border-radius: 50%;
    opacity: 0;
    transition: all 0.3s ease;
}

.carousel:hover .carousel-control-prev,
.carousel:hover .carousel-control-next {
    opacity: 1;
}

.carousel-control-prev {
    left: 1rem;
}

.carousel-control-next {
    right: 1rem;
}

.carousel-control-prev:hover,
.carousel-control-next:hover {
    background: rgba(17, 24, 39, 0.9);
}

.carousel-arrow {
    width: 20px;
    height: 20px;
    color: white;
}

/* Миниатюры */
.carousel-thumbnails {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
    gap: 0.75rem;
}

.thumbnail-item {
    position: relative;
    width: 100%;
    padding-bottom: 100%; /* Квадрат */
    background: white;
    border: 2px solid #e5e7eb;
    border-radius: 6px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.2s ease;
}

.thumbnail-item:hover {
    border-color: #9ca3af;
}

.thumbnail-item.active {
    border-color: #111827;
    box-shadow: 0 0 0 1px #111827;
}

.thumbnail-item img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 0.5rem;
}

/* ОВЕРЛЕЙ ДЛЯ РЕДАКТИРОВАНИЯ ФОТО */
.edit-image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: white;
    opacity: 0;
    transition: opacity 0.3s ease;
    cursor: pointer;
    z-index: 10;
}

.carousel-image-container:hover .edit-image-overlay {
    opacity: 1;
}

.edit-image-overlay svg {
    width: 48px;
    height: 48px;
    margin-bottom: 0.5rem;
}

.edit-image-overlay .overlay-text {
    font-weight: 600;
    font-size: 0.875rem;
}

/* РЕДАКТИРУЕМЫЕ ПОЛЯ В СТИЛЕ СТРАНИЦЫ ТОВАРА */
.editable-title {
    font-size: 1.75rem;
    font-weight: 600;
    color: #111827;
    margin-bottom: 1rem;
    line-height: 1.3;
    border: 2px dashed transparent;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    transition: all 0.2s ease;
    width: 100%;
}

.editable-title:focus {
    outline: none;
    border-color: #f59e0b;
    background: #fffbeb;
}

.editable-price {
    font-size: 1.5rem;
    font-weight: 700;
    color: #111827;
    border: 2px dashed transparent;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    transition: all 0.2s ease;
    width: auto;
    display: inline-block;
    min-width: 150px;
}

.editable-price:focus {
    outline: none;
    border-color: #f59e0b;
    background: #fffbeb;
}

.editable-description {
    color: #4b5563;
    line-height: 1.6;
    margin: 0;
    border: 2px dashed transparent;
    padding: 0.5rem;
    border-radius: 4px;
    transition: all 0.2s ease;
    width: 100%;
    min-height: 120px;
    font-family: inherit;
    resize: vertical;
}

.editable-description:focus {
    outline: none;
    border-color: #f59e0b;
    background: white;
}

.editable-category {
    font-size: 0.875rem;
    font-weight: 500;
    color: #6b7280;
    border: 2px dashed transparent;
    padding: 0.5rem;
    border-radius: 4px;
    transition: all 0.2s ease;
    background: transparent;
    margin-bottom: 0.5rem;
}

.editable-category:focus {
    outline: none;
    border-color: #f59e0b;
    background: #fffbeb;
}

/* Кнопки управления спецификацией */
.spec-controls {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.btn-add-spec {
    background-color: #111827;
    color: white;
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    font-weight: 600;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-add-spec:hover {
    background-color: #1f2937;
}

.editable-spec-label,
.editable-spec-value,
.editable-spec-unit {
    border: 1px dashed transparent;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    transition: all 0.2s ease;
    background: transparent;
    width: 100%;
    font-family: inherit;
}

.editable-spec-label {
    font-weight: 500;
    color: #6b7280;
}

.editable-spec-value,
.editable-spec-unit {
    color: #111827;
    font-weight: 500;
}

.editable-spec-label:focus,
.editable-spec-value:focus,
.editable-spec-unit:focus {
    outline: none;
    border-color: #f59e0b;
    background: #fffbeb;
}

.btn-remove-spec {
    color: #dc2626;
    background: none;
    border: none;
    padding: 0.5rem;
    cursor: pointer;
    font-size: 1.25rem;
    line-height: 1;
    transition: all 0.2s ease;
}

.btn-remove-spec:hover {
    color: #991b1b;
    transform: scale(1.1);
}

/* Кнопка сохранения */
.admin-save-button {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    background-color: #f59e0b;
    color: white;
    padding: 1rem 2rem;
    font-size: 1rem;
    font-weight: 600;
    border: none;
    border-radius: 8px;
    box-shadow: 0 10px 25px rgba(245, 158, 11, 0.3);
    cursor: pointer;
    transition: all 0.2s ease;
    z-index: 1000;
}

.admin-save-button:hover {
    background-color: #d97706;
    transform: translateY(-2px);
    box-shadow: 0 15px 30px rgba(245, 158, 11, 0.4);
}

.admin-save-button:active {
    transform: translateY(0);
}

.admin-cancel-button {
    position: fixed;
    bottom: 2rem;
    right: 14rem;
    background-color: #6b7280;
    color: white;
    padding: 1rem 2rem;
    font-size: 1rem;
    font-weight: 600;
    border: none;
    border-radius: 8px;
    box-shadow: 0 10px 25px rgba(107, 114, 128, 0.3);
    cursor: pointer;
    transition: all 0.2s ease;
    z-index: 1000;
    text-decoration: none;
    display: inline-block;
}

.admin-cancel-button:hover {
    background-color: #4b5563;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 15px 30px rgba(107, 114, 128, 0.4);
}

@media (max-width: 991px) {
    .carousel-thumbnails {
        grid-template-columns: repeat(auto-fill, minmax(70px, 1fr));
        gap: 0.5rem;
    }
}

@media (max-width: 575px) {
    .carousel-image-container {
        padding: 1rem;
    }
    
    .carousel-control-prev,
    .carousel-control-next {
        width: 32px;
        height: 32px;
    }
    
    .carousel-arrow {
        width: 16px;
        height: 16px;
    }
    
    .carousel-control-prev {
        left: 0.5rem;
    }
    
    .carousel-control-next {
        right: 0.5rem;
    }
    
    .carousel-thumbnails {
        grid-template-columns: repeat(auto-fill, minmax(60px, 1fr));
    }
    
    .editable-title {
        font-size: 1.5rem;
    }
    
    .admin-save-button,
    .admin-cancel-button {
        position: static;
        width: 100%;
        margin-top: 1rem;
    }
    
    .admin-cancel-button {
        margin-top: 0.5rem;
    }
}
</style>

<div class="container product-page py-4 py-md-5">
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="row g-4 g-lg-5">
            
            <!-- Левая колонка - Изображения -->
            <div class="col-lg-6">
                @if($product->images->count() > 0)
                    <!-- Карусель с несколькими фото -->
                    <div class="product-carousel-wrapper">
                        <div id="productCarousel" class="carousel slide">
                            <div class="carousel-inner">
                                <!-- Главное фото -->
                                <div class="carousel-item active">
                                    <div class="carousel-image-container">
                                        <img id="mainImagePreview" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                        
                                        <div class="edit-image-overlay" onclick="document.getElementById('mainImageInput').click()">
                                            <svg fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M15 12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h1.172a3 3 0 0 0 2.12-.879l.83-.828A1 1 0 0 1 6.827 3h2.344a1 1 0 0 1 .707.293l.828.828A3 3 0 0 0 12.828 5H14a1 1 0 0 1 1 1v6zM2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2z"/>
                                                <path d="M8 11a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5zm0 1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                            </svg>
                                            <span class="overlay-text">Zmień główne zdjęcie</span>
                                        </div>
                                        <input type="file" name="image" id="mainImageInput" class="d-none" accept="image/*" onchange="previewMainImage(this)">
                                    </div>
                                </div>
                                <!-- Дополнительные фото -->
                                @foreach($product->images as $galleryImg)
                                <div class="carousel-item">
                                    <div class="carousel-image-container">
                                        <img src="{{ asset('storage/' . $galleryImg->path) }}" alt="{{ $product->name }}">
                                        <div class="edit-image-overlay" style="cursor: default; opacity: 0.3;">
                                            <span class="overlay-text" style="font-size: 0.75rem;">Tylko podgląd</span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- Стрелки -->
                            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                                <svg class="carousel-arrow" fill="currentColor" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                                </svg>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                                <svg class="carousel-arrow" fill="currentColor" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Миниатюры -->
                        <div class="carousel-thumbnails">
                            <div class="thumbnail-item active" 
                                 data-bs-target="#productCarousel" 
                                 data-bs-slide-to="0">
                                <img id="thumbPreview" src="{{ asset('storage/' . $product->image) }}" alt="Miniatura">
                            </div>
                            
                            @foreach($product->images as $key => $galleryImg)
                            <div class="thumbnail-item" 
                                 data-bs-target="#productCarousel" 
                                 data-bs-slide-to="{{ $key + 1 }}">
                                <img src="{{ asset('storage/' . $galleryImg->path) }}" alt="Miniatura">
                            </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <!-- Одно фото без карусели -->
                    <div class="product-single-image">
                        <div class="carousel-image-container">
                            <img id="mainImagePreview" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                            
                            <div class="edit-image-overlay" onclick="document.getElementById('mainImageInput').click()">
                                <svg fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M15 12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h1.172a3 3 0 0 0 2.12-.879l.83-.828A1 1 0 0 1 6.827 3h2.344a1 1 0 0 1 .707.293l.828.828A3 3 0 0 0 12.828 5H14a1 1 0 0 1 1 1v6zM2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2z"/>
                                    <path d="M8 11a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5zm0 1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                </svg>
                                <span class="overlay-text">Zmień zdjęcie</span>
                            </div>
                            <input type="file" name="image" id="mainImageInput" class="d-none" accept="image/*" onchange="previewMainImage(this)">
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Правая колонка - Информация -->
            <div class="col-lg-6">
                <div class="product-info">
                    
                    <!-- Kategoria -->
                    <select name="category_id" class="editable-category" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    
                    <!-- Название товара -->
                    <input type="text" name="name" class="editable-title" value="{{ $product->name }}" required>
                    
                    <!-- Цена -->
                    <div style="margin-bottom: 1.5rem;">
                        <input type="number" step="0.01" name="price" class="editable-price" value="{{ $product->price }}" required>
                        <span style="font-size: 1.5rem; font-weight: 700; color: #111827; margin-left: 0.25rem;">zł</span>
                    </div>
                    
                    <!-- Кнопка добавления в корзину (неактивная) -->
                    <button type="button" class="btn btn-dark btn-lg border-0 shadow-lg position-relative overflow-hidden" disabled style="opacity: 0.6; cursor: not-allowed; width: 100%; max-width: 400px;">
                        <div class="fw-bold text-uppercase">
                            <i class="bi bi-cart-plus me-2"></i> Dodaj do koszyka
                        </div>
                    </button>
                    
                    <!-- Описание товара -->
                    <div class="product-description">
                        <h2 class="section-title">Opis produktu</h2>
                        <textarea name="description" class="editable-description">{{ $product->description }}</textarea>
                    </div>
                    
                    <!-- Спецификация -->
                    <div class="specifications">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h2 class="section-title mb-0">Specyfikacja techniczna</h2>
                            <button type="button" class="btn-add-spec" onclick="addSpecRow()">
                                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 4px;">
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                </svg>
                                Dodaj cechę
                            </button>
                        </div>
                        
                        <table class="spec-table" id="specsTable">
                            <tbody id="specsContainer">
                                @foreach($product->attributes as $index => $attribute)
                                <tr class="spec-row" id="spec-{{ $index }}">
                                    <td class="spec-label" style="position: relative;">
                                        <input type="text" name="specs[{{ $index }}][name]" class="editable-spec-label" value="{{ $attribute->name }}">
                                    </td>
                                    <td class="spec-value" style="position: relative;">
                                        <div style="display: flex; gap: 0.5rem; align-items: center;">
                                            <input type="text" name="specs[{{ $index }}][value]" class="editable-spec-value" value="{{ $attribute->pivot->value }}" style="flex: 1;">
                                            <input type="text" name="specs[{{ $index }}][unit]" class="editable-spec-unit" value="{{ $attribute->unit }}" style="width: 80px;" placeholder="jedn.">
                                            <button type="button" class="btn-remove-spec" onclick="removeSpec({{ $index }})" title="Usuń">×</button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
            
        </div>
        
        <!-- Кнопки управления -->
        <a href="{{ route('product', $product->slug) }}" class="admin-cancel-button">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 8px;">
                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
            </svg>
            Anuluj
        </a>
        <button type="submit" class="admin-save-button">
            <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 8px;">
                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
            </svg>
            Zapisz zmiany
        </button>
    </form>
</div>

<script>
// 1. Превью главного фото
function previewMainImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('mainImagePreview');
            preview.src = e.target.result;
            
            // Также обновляем миниатюру, если она есть
            const thumb = document.getElementById('thumbPreview');
            if (thumb) {
                thumb.src = e.target.result;
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// 2. Синхронизация активной миниатюры с каруселью
const myCarousel = document.getElementById('productCarousel');
const thumbnails = document.querySelectorAll('.thumbnail-item');

if (myCarousel) {
    myCarousel.addEventListener('slide.bs.carousel', function (event) {
        const index = event.to;
        thumbnails.forEach(thumb => thumb.classList.remove('active'));
        if(thumbnails[index]) {
            thumbnails[index].classList.add('active');
        }
    });
}

// 3. Логика добавления характеристик
let specIndex = {{ $product->attributes->count() }};

function addSpecRow() {
    const container = document.getElementById('specsContainer');
    
    const row = document.createElement('tr');
    row.className = 'spec-row';
    row.id = `spec-${specIndex}`;
    row.innerHTML = `
        <td class="spec-label" style="position: relative;">
            <input type="text" name="specs[${specIndex}][name]" class="editable-spec-label" placeholder="Nazwa cechy">
        </td>
        <td class="spec-value" style="position: relative;">
            <div style="display: flex; gap: 0.5rem; align-items: center;">
                <input type="text" name="specs[${specIndex}][value]" class="editable-spec-value" placeholder="Wartość" style="flex: 1;">
                <input type="text" name="specs[${specIndex}][unit]" class="editable-spec-unit" placeholder="jedn." style="width: 80px;">
                <button type="button" class="btn-remove-spec" onclick="removeSpec(${specIndex})" title="Usuń">×</button>
            </div>
        </td>
    `;
    
    container.appendChild(row);
    specIndex++;
}

function removeSpec(id) {
    const row = document.getElementById('spec-' + id);
    if (row) {
        row.remove();
    }
}
</script>

@endsection