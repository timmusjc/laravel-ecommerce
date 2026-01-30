@extends('layout')

@section('title', 'Nowy Produkt')

@section('main_content')

    <style>
        /* ====== Базовый стиль (как в edit) ====== */
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
            inset: 0;
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
            inset: 0;
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
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: .5rem;
        }

        /* ====== Модалка (как в edit) ====== */
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

        /* ====== Поля как в edit (крупно/красиво) ====== */
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

        .product-title-input {
            font-weight: 600;
            letter-spacing: -0.02em;
            line-height: 1.15;
            font-size: clamp(1.6rem, 1.2rem + 1.2vw, 2.2rem);
            padding: .35rem .6rem;
            width: 100%;
        }

        .price-wrap {
            position: relative;
            display: inline-block;
        }

        .product-price-input {
            font-weight: 500;
            letter-spacing: -0.02em;
            font-size: clamp(1.35rem, 1.1rem + 1vw, 1.9rem);
            padding: .35rem 2.2rem .35rem .6rem;
            width: 220px;
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

        .edit-category {
            width: auto;
            min-width: 220px;
            padding: .45rem .6rem;
            font-weight: 600;
            color: #111827;
            background: transparent;
            border-radius: 10px;
        }

        .buy-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 1.25rem;
        }

        .buy-btn {
            width: 100%;
        }

        input[type=number]::-webkit-outer-spin-button,
        input[type=number]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        /* ====== Specs (как в edit) ====== */
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

        /* ====== Preview новых файлов (как в edit) ====== */
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

        .chip-remove {
            border: none;
            background: transparent;
            color: #dc2626;
            font-weight: 800;
            padding: .1rem .35rem;
            border-radius: 8px;
        }

        .chip-remove:hover {
            background: #fee2e2;
        }

        /* ====== Fixed buttons (как в edit) ====== */
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

            .carousel-thumbnails {
                grid-template-columns: repeat(auto-fill, minmax(60px, 1fr));
            }

            .modal-close {
                top: 1rem;
                right: 1rem;
                font-size: 2.5rem;
            }
        }
    </style>

    <div class="container product-page py-4 py-md-5">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="createForm">
            @csrf

            <div class="row g-4 g-lg-5 align-items-stretch" id="topRow">

                {{-- LEFT: media (как в edit) --}}
                <div class="col-lg-6" id="leftCol">

                    <div class="product-carousel-wrapper">
                        <!-- Главное фото -->
                        <div class="product-single-image">
                            <div class="carousel-image-container" id="mainImageContainer" data-image="">
                                <div class="image-upload-placeholder" id="mainPlaceholder">
                                    <svg fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                                        <path
                                            d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z" />
                                    </svg>
                                    <div class="upload-text">Tutaj się pojawi główne zdjęcie</div>
                                </div>

                                <img id="mainImagePreview" class="image-preview">
                            </div>
                        </div>

                    </div>

                    {{-- Controls under media (те же кнопки что в edit) --}}
                    <div class="mt-3 d-grid gap-2">
                        <div class="buy-card">
                            <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between">
                                <div class="fw-semibold">Zdjęcia</div>

                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-outline-dark btn-sm" id="changeMainBtn">
                                        Dodaj główne zdjęcie
                                    </button>

                                    <button type="button" class="btn btn-outline-dark btn-sm" id="addGalleryBtn">
                                        Dodaj zdjęcia do galerii
                                    </button>
                                </div>
                            </div>

                            <input type="file" name="image" id="mainImageInput" class="d-none" accept="image/*"
                                required>
                            <input type="file" name="images[]" id="galleryImagesInput" class="d-none" accept="image/*"
                                multiple>

                            <div class="text-muted mt-2" style="font-size:.9rem;">
                                Główne zdjęcie jest wymagane. Galeria jest opcjonalna.
                            </div>

                            <div id="newFilesPreview" class="newfiles-list" style="display:none;"></div>
                        </div>
                    </div>

                </div>

                {{-- RIGHT: fields + specs (как в edit) --}}
                <div class="col-lg-6 d-flex" id="rightCol">
                    <div class="d-flex flex-column w-100" id="rightBox">

                        {{-- Buy-like block --}}
                        <div class="buy-card mb-3" id="buyBlock">
                            <div class="mb-2">
                                <label class="text-muted" style="font-size:.9rem;">Kategoria</label><br>
                                <select name="category_id" class="edit-category editable-like" required>
                                     <option value="" disabled {{ empty($selectedCategoryId) ? 'selected' : '' }}>-- Wybierz kategorię --</option>
                                    @foreach ($categories as $cat)
                                       <option value="{{ $cat->id }}" {{ (string)$selectedCategoryId === (string)$cat->id ? 'selected' : '' }}>
                                         {{ $cat->name }}
                                         </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-2">
                                <label class="text-muted" style="font-size:.9rem;">Nazwa produktu</label>
                                <input type="text" name="name" class="product-title-input editable-like"
                                    placeholder="Nazwa produktu..." required>
                            </div>

                            <div class="mb-2">
                                <label class="text-muted" style="font-size:.9rem;">Cena</label><br>
                                <div class="price-wrap">
                                    <input type="text" inputmode="decimal" name="price"
                                        class="product-price-input editable-like" placeholder="0.00" required>
                                    <span class="price-suffix">zł</span>
                                </div>
                            </div>

                            <button type="button" class="btn btn-dark btn-lg w-100" disabled
                                style="opacity:.55; cursor:not-allowed;">
                                <div class="fw-bold text-uppercase">
                                    <i class="bi bi-cart-plus me-2"></i> Dodaj do koszyka
                                </div>
                            </button>

                            <div class="text-muted mt-2" style="font-size:.9rem;">
                                (Podgląd — przycisk nieaktywny na stronie tworzenia)
                            </div>
                        </div>

                        {{-- Specyfikacja (как в edit) --}}
                        <div class="d-flex align-items-center justify-content-between mb-2" id="specHeader">
                            <h2 class="h5 mb-0">Specyfikacja techniczna</h2>
                            <button type="button" class="btn btn-outline-dark btn-sm" id="addSpecBtn">
                                Dodaj cechę
                            </button>
                        </div>

                        <div class="spec-scroll flex-grow-1" id="specsScroll">
                            <table class="spec-table" id="specsTable">
                                <tbody id="specsContainer"></tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>

            {{-- BOTTOM: Opis produktu (как в edit) --}}
            <div class="row mt-5">
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h2 class="h5 mb-0">Opis produktu (HTML)</h2>
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="togglePreviewBtn">
                            Podgląd
                        </button>
                    </div>

                    <div class="spec-scroll">
                        <div class="p-3 p-md-4">
                            <textarea name="description" id="descriptionInput" class="form-control editable-like"
                                style="min-height: 280px; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, 'Liberation Mono', 'Courier New', monospace;"
                                placeholder="Wklej tutaj HTML opis (nagłówki, listy, obrazki itd.)..."></textarea>

                            <div id="descriptionPreviewWrap" style="display:none; margin-top: 1rem;">
                                <div class="text-muted mb-2" style="font-size:.9rem;">Podgląd:</div>
                                <div id="descriptionPreview" class="p-3 border rounded" style="background:#fff;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bottom fixed admin actions (как в edit) --}}
            <div class="position-fixed bottom-0 end-0 p-4 d-flex gap-2" style="z-index: 1000;">
                <a href="{{ route('home') }}" class="btn btn-secondary shadow-sm">
                    Anuluj
                </a>
                <button type="submit" class="btn btn-success shadow-sm d-flex align-items-center gap-2">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v7.293l2.646-2.647a.5.5 0 0 1 .708.708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L7.5 9.293V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z" />
                    </svg>
                    Zapisz produkt
                </button>
            </div>

        </form>
    </div>

    {{-- Модалка (для preview главного фото) --}}
    <div id="imageModal" class="image-modal">
        <span class="modal-close">&times;</span>
        <img class="modal-content" id="modalImage">
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ====== MODAL (как в edit) ======
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');
            const closeBtn = document.querySelector('.modal-close');

            function openImageModal(src) {
                if (!src) return;
                modal.style.display = 'flex';
                modalImg.src = src;
                document.body.style.overflow = 'hidden';
            }

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

            // ====== MAIN IMAGE ======
            const mainPlaceholder = document.getElementById('mainPlaceholder');
            const mainInput = document.getElementById('mainImageInput');
            const changeMainBtn = document.getElementById('changeMainBtn');

            const mainPreview = document.getElementById('mainImagePreview');
            const mainContainer = document.getElementById('mainImageContainer');

            function setMainPreview(file) {
                if (!file || !file.type.startsWith('image/')) return;

                const reader = new FileReader();
                reader.onload = (e) => {
                    mainPreview.src = e.target.result;
                    mainPreview.style.display = 'block';
                    mainPlaceholder.style.display = 'none';
                    mainContainer.setAttribute('data-image', e.target.result);
                };
                reader.readAsDataURL(file);
            }

            mainPlaceholder?.addEventListener('click', () => mainInput.click());
            changeMainBtn?.addEventListener('click', () => mainInput.click());
            mainInput?.addEventListener('change', function() {
                if (this.files && this.files[0]) setMainPreview(this.files[0]);
            });

            // click on image to zoom
            mainContainer.style.cursor = 'zoom-in';
            mainContainer.addEventListener('click', function() {
                const src = this.getAttribute('data-image');
                if (src) openImageModal(src);
            });

            // ====== GALLERY FILES (как в edit: кнопка + preview chips + remove) ======
            const addGalleryBtn = document.getElementById('addGalleryBtn');
            const galleryInput = document.getElementById('galleryImagesInput');
            const newFilesPreview = document.getElementById('newFilesPreview');

            let galleryFiles = []; // держим собственный список, чтобы можно было удалять отдельные

            function syncGalleryInputFiles() {
                // пересобираем FileList через DataTransfer
                const dt = new DataTransfer();
                galleryFiles.forEach(f => dt.items.add(f));
                galleryInput.files = dt.files;
            }

            function renderGalleryChips() {
                newFilesPreview.innerHTML = '';

                if (!galleryFiles.length) {
                    newFilesPreview.style.display = 'none';
                    return;
                }
                newFilesPreview.style.display = 'flex';

                galleryFiles.forEach((file, idx) => {
                    const chip = document.createElement('div');
                    chip.className = 'newfile-chip';

                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.alt = 'new';

                    const name = document.createElement('div');
                    name.className = 'text-muted';
                    name.style.fontSize = '.85rem';
                    name.textContent = file.name.length > 18 ? (file.name.slice(0, 18) + '…') : file.name;

                    const remove = document.createElement('button');
                    remove.type = 'button';
                    remove.className = 'chip-remove';
                    remove.title = 'Usuń';
                    remove.textContent = '×';
                    remove.addEventListener('click', () => {
                        galleryFiles.splice(idx, 1);
                        syncGalleryInputFiles();
                        renderGalleryChips();
                    });

                    chip.appendChild(img);
                    chip.appendChild(name);
                    chip.appendChild(remove);
                    newFilesPreview.appendChild(chip);
                });
            }

            addGalleryBtn?.addEventListener('click', () => galleryInput.click());

            galleryInput?.addEventListener('change', function() {
                const files = Array.from(this.files || []).filter(f => f.type.startsWith('image/'));
                if (!files.length) return;

                // добавляем к уже выбранным (а не перетираем)
                galleryFiles = galleryFiles.concat(files);

                // простая защита от дублей по имени+размеру
                const seen = new Set();
                galleryFiles = galleryFiles.filter(f => {
                    const key = f.name + ':' + f.size;
                    if (seen.has(key)) return false;
                    seen.add(key);
                    return true;
                });

                syncGalleryInputFiles();
                renderGalleryChips();
            });

            // ====== SPECS (как в edit) ======
            let specIndex = 0;
            const addSpecBtn = document.getElementById('addSpecBtn');
            const specsContainer = document.getElementById('specsContainer');

            function addSpecRow() {
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
                    <button type="button" class="icon-btn danger" title="Usuń">×</button>
                </div>
            </td>
        `;
                tr.querySelector('.icon-btn.danger').addEventListener('click', () => tr.remove());
                specsContainer.appendChild(tr);
                specIndex++;
            }

            addSpecBtn?.addEventListener('click', addSpecRow);
            addSpecRow(); // одна строка по умолчанию

            // ====== DESCRIPTION preview toggle (как в edit) ======
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
