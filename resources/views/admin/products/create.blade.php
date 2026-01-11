@extends('layout')

@section('title', 'Nowy Produkt')

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

/* ЗАГЛУШКА ДЛЯ ЗАГРУЗКИ ФОТО */
.image-upload-placeholder {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #f9fafb;
    border: 2px dashed #d1d5db;
}

.image-upload-placeholder:hover {
    background: #f3f4f6;
    border-color: #9ca3af;
}

.image-upload-placeholder svg {
    width: 64px;
    height: 64px;
    color: #d1d5db;
    margin-bottom: 1rem;
}

.image-upload-placeholder .upload-text {
    color: #6b7280;
    font-size: 0.875rem;
    font-weight: 500;
}

.image-preview {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 2rem;
    display: none;
}

.thumbnail-upload-placeholder {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    background: #f9fafb;
    border: 2px dashed #d1d5db;
    transition: all 0.3s ease;
}

.thumbnail-upload-placeholder:hover {
    background: #f3f4f6;
    border-color: #9ca3af;
}

.thumbnail-upload-placeholder svg {
    width: 24px;
    height: 24px;
    color: #d1d5db;
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
    border-color: #111827;
    background: #f9fafb;
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
    border-color: #111827;
    background: #f9fafb;
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
    border-color: #111827;
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
    border-color: #111827;
    background: #f9fafb;
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
    border-color: #111827;
    background: #f9fafb;
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
    background-color: #16a34a;
    color: white;
    padding: 1rem 2rem;
    font-size: 1rem;
    font-weight: 600;
    border: none;
    border-radius: 8px;
    box-shadow: 0 10px 25px rgba(22, 163, 74, 0.3);
    cursor: pointer;
    transition: all 0.2s ease;
    z-index: 1000;
}

.admin-save-button:hover {
    background-color: #15803d;
    transform: translateY(-2px);
    box-shadow: 0 15px 30px rgba(22, 163, 74, 0.4);
}

.admin-save-button:active {
    transform: translateY(0);
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
    
    .carousel-thumbnails {
        grid-template-columns: repeat(auto-fill, minmax(60px, 1fr));
    }
    
    .editable-title {
        font-size: 1.5rem;
    }
    
    .admin-save-button {
        bottom: 1rem;
        right: 1rem;
        left: 1rem;
        width: calc(100% - 2rem);
    }
}
</style>

<div class="container product-page py-4 py-md-5">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row g-4 g-lg-5">
            
            <!-- Левая колонка - Изображения -->
            <div class="col-lg-6">
                <div class="product-carousel-wrapper">
                    <!-- Главное фото -->
                    <div class="product-single-image">
                        <div class="carousel-image-container">
                            <div class="image-upload-placeholder" onclick="document.getElementById('mainImageInput').click()">
                                <svg fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                    <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z"/>
                                </svg>
                                <div class="upload-text">Kliknij, aby dodać główne zdjęcie</div>
                            </div>
                            <img id="mainImagePreview" class="image-preview">
                        </div>
                        <input type="file" name="image" id="mainImageInput" class="d-none" accept="image/*" required onchange="previewMainImage(this)">
                    </div>

                    <!-- Миниатюры для дополнительных фото -->
                    <div class="carousel-thumbnails">
                        <div class="thumbnail-item">
                            <div class="thumbnail-upload-placeholder" onclick="document.getElementById('galleryImagesInput').click()">
                                <svg fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                </svg>
                            </div>
                        </div>
                        <div id="galleryPreviewContainer"></div>
                    </div>
                    <input type="file" name="images[]" id="galleryImagesInput" class="d-none" accept="image/*" multiple onchange="previewGalleryImages(this)">
                    <div class="form-text mt-2" style="color: #6b7280; font-size: 0.875rem;">
                        <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 4px;">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                        </svg>
                        Kliknij na "+" aby dodać galerię zdjęć (opcjonalnie)
                    </div>
                </div>
            </div>
            
            <!-- Правая колонка - Информация -->
            <div class="col-lg-6">
                <div class="product-info">
                    
                    <!-- Kategoria -->
                    <select name="category_id" class="editable-category" required>
                        <option value="" disabled selected>-- Wybierz kategorię --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    
                    <!-- Название товара -->
                    <input type="text" name="name" class="editable-title" placeholder="Nazwa produktu..." required>
                    
                    <!-- Цена -->
                    <div style="margin-bottom: 1.5rem;">
                        <input type="number" step="0.01" name="price" class="editable-price" placeholder="0.00" required>
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
                        <textarea name="description" class="editable-description" placeholder="Opisz szczegółowo produkt..."></textarea>
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
                                <!-- Спецификации будут добавляться сюда -->
                            </tbody>
                        </table>
                        
                        <div class="form-text mt-3" style="color: #6b7280; font-size: 0.875rem;">
                            <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 4px;">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                            </svg>
                            Jeśli wpiszesz nową nazwę cechy, system sam ją utworzy
                        </div>
                    </div>
                    
                </div>
            </div>
            
        </div>
        
        <!-- Кнопка сохранения -->
        <button type="submit" class="admin-save-button">
            <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 8px;">
                <path d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v7.293l2.646-2.647a.5.5 0 0 1 .708.708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L7.5 9.293V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z"/>
            </svg>
            Zapisz produkt
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
            const placeholder = document.querySelector('.image-upload-placeholder');
            preview.src = e.target.result;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// 2. Превью галереи
function previewGalleryImages(input) {
    const container = document.getElementById('galleryPreviewContainer');
    container.innerHTML = '';
    
    if (input.files) {
        Array.from(input.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const thumbHtml = `
                    <div class="thumbnail-item">
                        <img src="${e.target.result}" alt="Gallery ${index + 1}">
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', thumbHtml);
            }
            reader.readAsDataURL(file);
        });
    }
}

// 3. Логика добавления характеристик
let specIndex = 0;

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

// Добавим одну пустую строку при загрузке
document.addEventListener('DOMContentLoaded', function() {
    addSpecRow();
});
</script>

@endsection