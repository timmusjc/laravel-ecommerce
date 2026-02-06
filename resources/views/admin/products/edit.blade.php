@extends('layout')

@section('title', 'Edycja: ' . $product->name)

@section('main_content')

    <style>
        /* ====== Твой стиль карусели/миниатюр (оставляем) ====== */
        .product-carousel-wrapper {
            width: 100%;
        }

        .carousel {
            position: relative;
            width: 100%;
            padding-bottom: 100%;
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

        .carousel-thumbnails {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
            gap: .75rem;
        }

        .thumbnail-item {
            position: relative;
            width: 100%;
            padding-bottom: 100%;
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 6px;
            overflow: hidden;
            cursor: pointer;
            transition: all .2s ease;
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
            padding: .5rem;
        }

        /* ====== Модалка (оставляем твою) ====== */
        .image-modal {
            display: none;
            position: fixed;
            z-index: 10000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.95);
            align-items: center;
            justify-content: center;
            animation: fadeIn .3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .modal-content {
            max-width: 90%;
            max-height: 90%;
            width: auto;
            height: auto;
            object-fit: contain;
            animation: zoomIn .3s ease;
        }

        @keyframes zoomIn {
            from {
                transform: scale(.8);
            }

            to {
                transform: scale(1);
            }
        }

        .modal-close {
            position: absolute;
            top: 2rem;
            right: 2rem;
            color: white;
            font-size: 3rem;
            font-weight: 300;
            cursor: pointer;
            transition: opacity .2s ease;
            line-height: 1;
            z-index: 10001;
        }

        .modal-close:hover {
            opacity: .7;
        }

        /* ====== Новый стиль формы (минимально, под твой дизайн) ====== */
        .product-title {
            font-weight: 600;
            letter-spacing: -0.02em;
            line-height: 1.15;
            font-size: clamp(1.6rem, 1.2rem + 1.2vw, 2.2rem);
            margin-bottom: .75rem;
        }

        .product-price {
            font-weight: 500;
            letter-spacing: -0.02em;
            font-size: clamp(1.35rem, 1.1rem + 1vw, 1.9rem);
            margin-bottom: 1rem;
        }

        .buy-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 1.25rem;
        }

        .edit-field {
            border: 2px dashed transparent;
            border-radius: 8px;
            transition: all .2s ease;
        }

        .edit-field:focus {
            outline: none;
            border-color: #f59e0b;
            background: #fffbeb;
        }

        .spec-scroll {
            overflow: auto;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            background: #fff;
        }

        .spec-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        .spec-table td {
            padding: .75rem .9rem;
            border-bottom: 1px solid #eef2f7;
            vertical-align: top;
        }

        .spec-table tr:last-child td {
            border-bottom: none;
        }

        .spec-label {
            color: #6b7280;
            width: 45%;
        }

        .spec-value {
            font-weight: 600;
            color: #111827;
        }

        /* input внутри таблицы — без ломания верстки */
        .spec-input {
            width: 100%;
            border: 1px dashed transparent;
            border-radius: 6px;
            padding: .4rem .5rem;
            transition: all .15s ease;
            background: transparent;
        }

        .spec-input:focus {
            outline: none;
            border-color: #f59e0b;
            background: #fffbeb;
        }

        .spec-row-actions {
            display: flex;
            gap: .5rem;
            align-items: center;
        }

        .icon-btn {
            border: none;
            background: transparent;
            padding: .35rem .5rem;
            border-radius: 8px;
            transition: all .15s ease;
        }

        .icon-btn:hover {
            background: #f3f4f6;
        }

        .icon-btn.danger {
            color: #dc2626;
        }

        .icon-btn.danger:hover {
            background: #fee2e2;
        }

        /* Галерея существующих фото — чекбокс удаления */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
            gap: .75rem;
        }

        .gallery-tile {
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            overflow: hidden;
            background: #fff;
        }

        .gallery-tile .imgbox {
            position: relative;
            width: 100%;
            padding-bottom: 100%;
        }

        .gallery-tile img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: .5rem;
        }

        .gallery-tile .tile-footer {
            padding: .5rem .65rem;
            border-top: 1px solid #eef2f7;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: .5rem;
            font-size: .85rem;
        }

        /* Preview новых файлов */
        .newfiles-list {
            display: flex;
            flex-wrap: wrap;
            gap: .75rem;
            margin-top: .75rem;
        }

        .newfile-chip {
            display: flex;
            align-items: center;
            gap: .5rem;
            border: 1px solid #e5e7eb;
            border-radius: 999px;
            padding: .35rem .6rem;
            background: #fff;
        }

        .newfile-chip img {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            object-fit: cover;
        }

        @media (max-width: 991px) {
            .carousel-thumbnails {
                grid-template-columns: repeat(auto-fill, minmax(70px, 1fr));
                gap: .5rem;
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
                left: .5rem;
            }

            .carousel-control-next {
                right: .5rem;
            }

            .carousel-thumbnails {
                grid-template-columns: repeat(auto-fill, minmax(60px, 1fr));
            }

            .modal-close {
                top: 1rem;
                right: 1rem;
                font-size: 2.5rem;
            }
        }

        input[type=number]::-webkit-outer-spin-button,
        input[type=number]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        /* Стили полей в твоём стиле */
        .editable-like {
            border: 2px dashed transparent;
            border-radius: 10px;
            transition: all .2s ease;
            background: transparent;
        }

        .editable-like:focus {
            outline: none;
            border-color: #f59e0b;
            background: #fffbeb;
        }

        /* Название (инпут выглядит как заголовок товара) */
        .edit-name {
            font-weight: 600;
            letter-spacing: -0.02em;
            line-height: 1.15;
            font-size: clamp(1.6rem, 1.2rem + 1.2vw, 2.2rem);
            padding: .35rem .6rem;
            width: 100%;
        }

        /* Цена (крупно, но аккуратно) */
        .price-wrap {
            position: relative;
            display: inline-block;
        }

        .edit-price {
            font-weight: 500;
            letter-spacing: -0.02em;
            font-size: clamp(1.35rem, 1.1rem + 1vw, 1.9rem);
            padding: .35rem 2.2rem .35rem .6rem;
            /* справа место под "zł" */
            width: 220px;
            /* не во всю ширину */
        }

        .price-suffix {
            position: absolute;
            right: .7rem;
            top: 50%;
            transform: translateY(-50%);
            font-weight: 500;
            font-size: clamp(1.35rem, 1.1rem + 1vw, 1.9rem);
            color: #111827;
            pointer-events: none;
        }

        /* Категория НЕ на всю ширину */
        .edit-category {
            width: auto;
            min-width: 220px;
            padding: .45rem .6rem;
            font-weight: 600;
            color: #111827;
            background: transparent;
            border-radius: 10px;
        }

        /* Кнопка "Dodaj do koszyka" как на товаре */
        .buy-btn {
            width: 100%;
        }

        /* Кнопки под фото — аккуратно */
        .media-actions {
            display: flex;
            gap: .5rem;
            flex-wrap: wrap;
        }

        /* Кнопка-иконка вместо текста Podgląd (чтобы не не влезало) */
        .icon-chip {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            background: #fff;
            transition: all .15s ease;
        }

        .icon-chip:hover {
            background: #f3f4f6;
        }

        /* Галерея плиткой */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
            gap: .75rem;
        }

        .gallery-tile {
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            overflow: hidden;
            background: #fff;
        }

        .gallery-tile .imgbox {
            position: relative;
            width: 100%;
            padding-bottom: 100%;
        }

        .gallery-tile img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: .5rem;
        }

        .gallery-tile .tile-footer {
            padding: .5rem .65rem;
            border-top: 1px solid #eef2f7;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: .4rem;
            font-size: .85rem;
        }
    </style>

    <div class="container product-page py-4 py-md-5">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data"
            id="editForm">
            @csrf
            @method('PUT')

            <div class="row g-4 g-lg-5 align-items-stretch" id="topRow">

                <div class="col-lg-6" id="leftCol">
                    @php
                        $hasGallery = $product->images->count() > 0;
                    @endphp

                    @if ($hasGallery)
                        <div class="product-carousel-wrapper">
                            <div id="productCarousel" class="carousel slide">
                                <div class="carousel-inner">

                                    <div class="carousel-item active">
                                        <div class="carousel-image-container"
                                            data-image="{{ asset('storage/' . $product->image) }}">
                                            <img id="mainImagePreview" src="{{ asset('storage/' . $product->image) }}"
                                                alt="{{ $product->name }}">
                                        </div>
                                    </div>

                                    @foreach ($product->images as $galleryImg)
                                        <div class="carousel-item">
                                            <div class="carousel-image-container"
                                                data-image="{{ asset('storage/' . $galleryImg->path) }}">
                                                <img src="{{ asset('storage/' . $galleryImg->path) }}"
                                                    alt="{{ $product->name }}">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel"
                                    data-bs-slide="prev">
                                    <svg class="carousel-arrow" fill="currentColor" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" />
                                    </svg>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel"
                                    data-bs-slide="next">
                                    <svg class="carousel-arrow" fill="currentColor" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
                                    </svg>
                                </button>
                            </div>


                        </div>
                    @else
                        <div class="product-single-image">
                            <div class="carousel-image-container" data-image="{{ asset('storage/' . $product->image) }}">
                                <img id="mainImagePreview" src="{{ asset('storage/' . $product->image) }}"
                                    alt="{{ $product->name }}">
                            </div>
                        </div>
                    @endif

                    <div class="mt-3 d-grid gap-2">

                        <div class="buy-card">

                            <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between">
                                <div class="fw-semibold">Zdjęcia</div>

                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-outline-dark btn-sm" id="changeMainBtn">
                                        Zmień główne zdjęcie
                                    </button>

                                    <button type="button" class="btn btn-outline-dark btn-sm" id="addGalleryBtn">
                                        Dodaj zdjęcia do galerii
                                    </button>
                                </div>
                            </div>

                            <input type="file" name="image" id="mainImageInput" class="d-none" accept="image/*">
                            <input type="file" name="images[]" id="galleryImagesInput" class="d-none" accept="image/*"
                                multiple>

                            <div class="text-muted mt-2" style="font-size:.9rem;">
                                Główne zdjęcie wyświetla się jako pierwsze. Galeria to dodatkowe zdjęcia w karuzeli.
                            </div>

                            <div id="newFilesPreview" class="newfiles-list" style="display:none;"></div>

                        </div>

                        @if ($product->images->count() > 0)
                            <div class="buy-card">
                                <div class="fw-semibold mb-2">Aktualna galeria</div>

                                <div class="gallery-grid">
                                    @foreach ($product->images as $galleryImg)
                                        <div class="gallery-tile">
                                            <div class="imgbox">
                                                <img src="{{ asset('storage/' . $galleryImg->path) }}" alt="gallery">
                                            </div>
                                            <div class="tile-footer">
                                                <label class="d-flex align-items-center gap-2 m-0">
                                                    <input type="checkbox" name="remove_gallery[]"
                                                        value="{{ $galleryImg->id }}">
                                                    Usuń
                                                </label>

                                                <button type="button" class="icon-chip" title="Podgląd"
                                                    data-image="{{ asset('storage/' . $galleryImg->path) }}"
                                                    onclick="openImageModal(this.getAttribute('data-image'))">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                        fill="currentColor" viewBox="0 0 16 16">
                                                        <path
                                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                                        <path
                                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="text-muted mt-2" style="font-size:.9rem;">
                                    Zaznacz zdjęcia do usunięcia i kliknij “Zapisz”.
                                </div>
                            </div>
                        @endif

                    </div>
                </div>

                <div class="col-lg-6 d-flex" id="rightCol">
                    <div class="d-flex flex-column w-100" id="rightBox">

                        <div class="buy-card mb-3" id="buyBlock">
                            <div class="mb-2">
                                <label class="text-muted" style="font-size:.9rem;">Kategoria</label><br>
                                <select name="category_id" class="edit-category editable-like" required>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-2">
                                <label class="text-muted" style="font-size:.9rem;">Nazwa produktu</label>
                                <input type="text" name="name" class="edit-name editable-like"
                                    value="{{ $product->name }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="text-muted" style="font-size:.9rem;">Cena</label><br>
                                <div class="price-wrap">
                                    <input type="text" inputmode="decimal" name="price"
                                        class="edit-price editable-like"
                                        value="{{ number_format($product->price, 2, '.', '') }}" autocomplete="off"
                                        required>
                                    <span class="price-suffix">zł</span>
                                </div>
                            </div>

                            <button type="button"
                                class="btn btn-dark btn-lg border-0 shadow-lg position-relative overflow-hidden buy-btn"
                                disabled style="opacity:.6; cursor:not-allowed;">
                                <div class="fw-bold text-uppercase">
                                    <i class="bi bi-cart-plus me-2"></i> Dodaj do koszyka
                                </div>
                            </button>

                            <div class="text-muted mt-2" style="font-size:.9rem;">
                                (Podgląd — przycisk nieaktywny na stronie edycji)
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mb-2" id="specHeader">
                            <h2 class="h5 mb-0">Specyfikacja techniczna</h2>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-dark btn-sm" id="addSpecBtn">
                                    Dodaj cechę
                                </button>

                                @if ($product->attributes->count() > 10)
                                    <button type="button" class="btn btn-outline-secondary btn-sm" id="toggleSpecsBtn">
                                        Rozwiń
                                    </button>
                                @endif
                            </div>
                        </div>

                        <div class="spec-scroll flex-grow-1" id="specsScroll">
                            <table class="spec-table" id="specsTable">
                                <tbody id="specsContainer">
                                    @foreach ($product->attributes as $index => $attribute)
                                        <tr class="spec-row" id="spec-{{ $index }}">
                                            <td class="spec-label">
                                                <input type="text" name="specs[{{ $index }}][name]"
                                                    class="spec-input" value="{{ $attribute->name }}"
                                                    placeholder="Nazwa cechy">
                                            </td>
                                            <td class="spec-value">
                                                <div class="spec-row-actions">
                                                    <input type="text" name="specs[{{ $index }}][value]"
                                                        class="spec-input" value="{{ $attribute->pivot->value }}"
                                                        placeholder="Wartość" style="flex:1;">
                                                    <input type="text" name="specs[{{ $index }}][unit]"
                                                        class="spec-input" value="{{ $attribute->unit }}"
                                                        placeholder="jedn." style="width:90px;">
                                                    <button type="button" class="icon-btn danger" title="Usuń"
                                                        onclick="removeSpec({{ $index }})">×</button>
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

            <div class="row mt-5">
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h2 class="h5 mb-0">Opis produktu (HTML)</h2>

                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="togglePreviewBtn">
                                Podgląd
                            </button>
                        </div>
                    </div>

                    <div class="spec-scroll">
                        <div class="p-3 p-md-4">
                            <textarea name="description" id="descriptionInput" class="form-control edit-field"
                                style="min-height: 280px; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, 'Liberation Mono', 'Courier New', monospace;">{{ $product->description }}</textarea>

                            <div id="descriptionPreviewWrap" style="display:none; margin-top: 1rem;">
                                <div class="text-muted mb-2" style="font-size:.9rem;">Podgląd (tak będzie wyglądać na
                                    stronie produktu):</div>
                                <div id="descriptionPreview" class="p-3 border rounded" style="background:#fff;"></div>
                            </div>

                            <div class="text-muted mt-3" style="font-size:.9rem;">
                                Wskazówka: możesz używać tagów HTML: <code>&lt;h2&gt;</code>, <code>&lt;p&gt;</code>,
                                <code>&lt;ul&gt;</code>, <code>&lt;img&gt;</code> itd.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="position-fixed bottom-0 end-0 p-4 d-flex gap-2" style="z-index: 1000;">
                <a href="{{ route('product', $product->slug) }}" class="btn btn-secondary shadow-sm">
                    Anuluj
                </a>
                <button type="submit" class="btn btn-warning shadow-sm d-flex align-items-center gap-2">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                    </svg>
                    Zapisz zmiany
                </button>
            </div>

        </form>
    </div>

    <div id="imageModal" class="image-modal">
        <span class="modal-close">&times;</span>
        <img class="modal-content" id="modalImage">
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const myCarousel = document.getElementById('productCarousel');
            const thumbnails = document.querySelectorAll('.thumbnail-item');
            if (myCarousel) {
                myCarousel.addEventListener('slide.bs.carousel', function(event) {
                    const index = event.to;
                    thumbnails.forEach(t => t.classList.remove('active'));
                    if (thumbnails[index]) thumbnails[index].classList.add('active');
                });
            }

            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');
            const closeBtn = document.querySelector('.modal-close');

            window.openImageModal = function(src) {
                modal.style.display = 'flex';
                modalImg.src = src;
                document.body.style.overflow = 'hidden';
            }

            document.querySelectorAll('.carousel-image-container').forEach(container => {
                container.style.cursor = 'zoom-in';
                container.addEventListener('click', function() {
                    const src = this.getAttribute('data-image');
                    if (src) openImageModal(src);
                });
            });

            function closeModal() {
                modal.style.display = 'none';
                modalImg.src = '';
                document.body.style.overflow = 'auto';
            }
            closeBtn?.addEventListener('click', closeModal);
            modal?.addEventListener('click', (e) => {
                if (e.target === modal) closeModal();
            });
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && modal.style.display === 'flex') closeModal();
            });

            const changeMainBtn = document.getElementById('changeMainBtn');
            const mainImageInput = document.getElementById('mainImageInput');
            const mainImagePreview = document.getElementById('mainImagePreview');
            const thumbPreview = document.getElementById('thumbPreview');

            changeMainBtn?.addEventListener('click', () => mainImageInput.click());

            mainImageInput?.addEventListener('change', function() {
                if (!this.files || !this.files[0]) return;
                const file = this.files[0];

                if (!file.type.startsWith('image/')) return;

                const url = URL.createObjectURL(file);
                if (mainImagePreview) mainImagePreview.src = url;
                if (thumbPreview) thumbPreview.src = url;
            });

            const addGalleryBtn = document.getElementById('addGalleryBtn');
            const galleryInput = document.getElementById('galleryImagesInput');
            const newFilesPreview = document.getElementById('newFilesPreview');

            addGalleryBtn?.addEventListener('click', () => galleryInput.click());

            galleryInput?.addEventListener('change', function() {
                if (!this.files) return;

                newFilesPreview.innerHTML = '';
                const files = Array.from(this.files).filter(f => f.type.startsWith('image/'));

                if (files.length === 0) {
                    newFilesPreview.style.display = 'none';
                    return;
                }

                newFilesPreview.style.display = 'flex';

                files.forEach(file => {
                    const chip = document.createElement('div');
                    chip.className = 'newfile-chip';

                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.alt = 'new';

                    const name = document.createElement('div');
                    name.className = 'text-muted';
                    name.style.fontSize = '.85rem';
                    name.textContent = file.name.length > 18 ? (file.name.slice(0, 18) + '…') : file
                        .name;

                    chip.appendChild(img);
                    chip.appendChild(name);
                    newFilesPreview.appendChild(chip);
                });
            });

            let specIndex = {{ $product->attributes->count() }};
            const addSpecBtn = document.getElementById('addSpecBtn');
            const specsContainer = document.getElementById('specsContainer');

            addSpecBtn?.addEventListener('click', function() {
                const tr = document.createElement('tr');
                tr.className = 'spec-row';
                tr.id = `spec-${specIndex}`;
                tr.innerHTML = `
            <td class="spec-label">
                <input type="text" name="specs[${specIndex}][name]" class="spec-input" placeholder="Nazwa cechy">
            </td>
            <td class="spec-value">
                <div class="spec-row-actions">
                    <input type="text" name="specs[${specIndex}][value]" class="spec-input" placeholder="Wartość" style="flex:1;">
                    <input type="text" name="specs[${specIndex}][unit]" class="spec-input" placeholder="jedn." style="width:90px;">
                    <button type="button" class="icon-btn danger" title="Usuń" onclick="removeSpec(${specIndex})">×</button>
                </div>
            </td>
        `;
                specsContainer.appendChild(tr);
                specIndex++;
                syncSpecsMaxHeight();
            });

            window.removeSpec = function(id) {
                const row = document.getElementById('spec-' + id);
                if (row) row.remove();
                syncSpecsMaxHeight();
            }

            const carouselBox = document.getElementById('productCarousel');
            const singleBox = document.querySelector('.product-single-image');
            const buyBlock = document.getElementById('buyBlock');
            const specHeader = document.getElementById('specHeader');
            const specsScroll = document.getElementById('specsScroll');
            const toggleBtn = document.getElementById('toggleSpecsBtn');
            let expanded = false;

            function getImageBoxHeight() {
                if (carouselBox) return carouselBox.offsetHeight;
                if (singleBox) return singleBox.offsetHeight;
                return null;
            }

            function syncSpecsMaxHeight() {
                if (!specsScroll || !buyBlock || !specHeader) return;

                const isLg = window.matchMedia('(min-width: 992px)').matches;
                if (!isLg) {
                    specsScroll.style.maxHeight = '';
                    return;
                }
                if (expanded) return;

                const imgH = getImageBoxHeight();
                if (!imgH) return;

                const buyH = buyBlock.offsetHeight;
                const headH = specHeader.offsetHeight;
                const reserve = 16;

                const max = Math.max(160, imgH - buyH - headH - reserve);
                specsScroll.style.maxHeight = max + 'px';
            }

            syncSpecsMaxHeight();
            window.addEventListener('resize', syncSpecsMaxHeight);

            toggleBtn?.addEventListener('click', function() {
                expanded = !expanded;
                toggleBtn.textContent = expanded ? 'Zwiń' : 'Rozwiń';
                if (expanded) specsScroll.style.maxHeight = '';
                else syncSpecsMaxHeight();
            });

            const togglePreviewBtn = document.getElementById('togglePreviewBtn');
            const descriptionInput = document.getElementById('descriptionInput');
            const previewWrap = document.getElementById('descriptionPreviewWrap');
            const preview = document.getElementById('descriptionPreview');

            function renderPreview() {
                preview.innerHTML = descriptionInput.value;
            }

            let previewOn = false;
            togglePreviewBtn?.addEventListener('click', function() {
                previewOn = !previewOn;
                togglePreviewBtn.textContent = previewOn ? 'Edytuj' : 'Podgląd';
                previewWrap.style.display = previewOn ? 'block' : 'none';
                descriptionInput.style.display = previewOn ? 'none' : 'block';
                if (previewOn) renderPreview();
            });

            descriptionInput?.addEventListener('input', function() {
                if (previewOn) renderPreview();
            });

        });
    </script>

@endsection
