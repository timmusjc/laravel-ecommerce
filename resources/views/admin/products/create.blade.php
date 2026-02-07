@extends('layout')

@section('title', 'Nowy Produkt')

@section('main_content')

    

    <div class="container product-page py-4 py-md-5">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="createForm">
            @csrf

            <div class="row g-4 g-lg-5 align-items-stretch" id="topRow">
                <div class="col-lg-6" id="leftCol">

                    <div class="product-carousel-wrapper">
                        <div class="product-single-image">
                            <div class="carousel-image-container zoomable" id="mainImageContainer" data-image="">
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

                            <div class="text-muted mt-2 u-font-size-09">
                                Główne zdjęcie jest wymagane. Galeria jest opcjonalna.
                            </div>

                            <div id="newFilesPreview" class="newfiles-list u-display-none"></div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-6 d-flex" id="rightCol">
                    <div class="d-flex flex-column w-100" id="rightBox">

                        <div class="buy-card mb-3" id="buyBlock">
                            <div class="mb-2">
                                <label class="text-muted u-font-size-09">Kategoria</label><br>
                                <select name="category_id" class="edit-category editable-like" required>
                                    <option value="" disabled {{ empty($selectedCategoryId) ? 'selected' : '' }}>--
                                        Wybierz kategorię --</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ (string) $selectedCategoryId === (string) $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-2">
                                <label class="text-muted u-font-size-09">Nazwa produktu</label>
                                <input type="text" name="name" class="product-title-input editable-like"
                                    placeholder="Nazwa produktu..." required>
                            </div>

                            <div class="mb-2">
                                <label class="text-muted u-font-size-09">Cena</label><br>
                                <div class="price-wrap">
                                    <input type="text" inputmode="decimal" name="price"
                                        class="product-price-input editable-like" placeholder="0.00" required>
                                    <span class="price-suffix">zł</span>
                                </div>
                            </div>

                            <button type="button" class="btn btn-dark btn-lg w-100 u-opacity-55" disabled>
                                <div class="fw-bold text-uppercase">
                                    <i class="bi bi-cart-plus me-2"></i> Dodaj do koszyka
                                </div>
                            </button>

                            <div class="text-muted mt-2 u-font-size-09">
                                (Podgląd — przycisk nieaktywny na stronie tworzenia)
                            </div>
                        </div>

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
                            <textarea name="description" id="descriptionInput"
                                class="form-control editable-like u-min-height-280 u-font-mono"
                                placeholder="Wklej tutaj HTML opis (nagłówki, listy, obrazki itd.)..."></textarea>

                            <div id="descriptionPreviewWrap" class="u-display-none u-margin-top-1rem">
                                <div class="text-muted mb-2 u-font-size-09">Podgląd:</div>
                                <div id="descriptionPreview" class="p-3 border rounded u-bg-white"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="position-fixed bottom-0 end-0 p-4 d-flex gap-2 u-z-1000">
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

    <div id="imageModal" class="image-modal">
        <span class="modal-close">&times;</span>
        <img class="modal-content" id="modalImage">
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

            mainContainer.addEventListener('click', function() {
                const src = this.getAttribute('data-image');
                if (src) openImageModal(src);
            });

            const addGalleryBtn = document.getElementById('addGalleryBtn');
            const galleryInput = document.getElementById('galleryImagesInput');
            const newFilesPreview = document.getElementById('newFilesPreview');

            let galleryFiles = [];

            function syncGalleryInputFiles() {
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
                    name.className = 'text-muted newfile-name';
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

                galleryFiles = galleryFiles.concat(files);

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
                    <input type="text" name="specs[${specIndex}][value]" class="spec-input spec-input-flex" placeholder="Wartość">
                    <input type="text" name="specs[${specIndex}][unit]" class="spec-input spec-input-unit" placeholder="jedn.">
                    <button type="button" class="icon-btn danger" title="Usuń">×</button>
                </div>
            </td>
        `;
                tr.querySelector('.icon-btn.danger').addEventListener('click', () => tr.remove());
                specsContainer.appendChild(tr);
                specIndex++;
            }

            addSpecBtn?.addEventListener('click', addSpecRow);
            addSpecRow();

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
