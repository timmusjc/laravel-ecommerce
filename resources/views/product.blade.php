@extends('layout')

@section('title')
    {{ $product->name }}
@endsection

@section('main_content')

    <style>
        /* ===================================
           ОСТАВЛЯЕМ ТВОЙ СТИЛЬ, УБИРАЕМ ЛИШНЕЕ
           (админ-кнопки теперь на Bootstrap)
           =================================== */

        /* Типографика/гармония справа */
        .product-title{
            font-weight: 600;
            letter-spacing: -0.02em;
            line-height: 1.15;
            font-size: clamp(1.6rem, 1.2rem + 1.2vw, 2.2rem);
            margin-bottom: .75rem;
        }
        .product-price{
            font-weight: 500;
            letter-spacing: -0.02em;
            font-size: clamp(1.35rem, 1.1rem + 1vw, 1.9rem);
            margin-bottom: 1.25rem;
        }
        .buy-card{
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 1.25rem;
        }

        /* ===================================
           КАРУСЕЛЬ НА СТРАНИЦЕ ТОВАРА (твой стиль)
           =================================== */

        .product-carousel-wrapper { width: 100%; }

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

        .carousel-inner { position: absolute; top: 0; left: 0; right: 0; bottom: 0; }
        .carousel-item { height: 100%; }

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
            top: 0; left: 0; right: 0; bottom: 0;
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
        .carousel:hover .carousel-control-next { opacity: 1; }

        .carousel-control-prev { left: 1rem; }
        .carousel-control-next { right: 1rem; }

        .carousel-control-prev:hover,
        .carousel-control-next:hover { background: rgba(17, 24, 39, 0.9); }

        .carousel-arrow { width: 20px; height: 20px; color: white; }

        .carousel-thumbnails {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
            gap: 0.75rem;
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
            transition: all 0.2s ease;
        }

        .thumbnail-item:hover { border-color: #9ca3af; }
        .thumbnail-item.active {
            border-color: #111827;
            box-shadow: 0 0 0 1px #111827;
        }

        .thumbnail-item img {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            object-fit: contain;
            padding: 0.5rem;
        }

        /* Твоя модалка */
        .image-modal {
            display: none;
            position: fixed;
            z-index: 10000;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.95);
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        .modal-content {
            max-width: 90%;
            max-height: 90%;
            width: auto; height: auto;
            object-fit: contain;
            animation: zoomIn 0.3s ease;
        }

        @keyframes zoomIn { from { transform: scale(0.8); } to { transform: scale(1); } }

        .modal-close {
            position: absolute;
            top: 2rem; right: 2rem;
            color: white;
            font-size: 3rem;
            font-weight: 300;
            cursor: pointer;
            transition: opacity 0.2s ease;
            line-height: 1;
            z-index: 10001;
        }

        .modal-close:hover { opacity: 0.7; }

        /* Скролл-область спецификации (чтобы длинная таблица не ломала верх) */
        .spec-scroll {
    overflow: auto;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    background: #fff;
}

/* По желанию: чтобы скролл выглядел аккуратнее */
.spec-scroll::-webkit-scrollbar { width: 10px; }
.spec-scroll::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 10px; }
.spec-scroll::-webkit-scrollbar-track { background: #f9fafb; }

        /* Мелкая косметика для таблицы (похоже на твой стиль) */
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
        .spec-table tr:last-child td { border-bottom: none; }
        .spec-label { color: #6b7280; width: 45%; }
        .spec-value { font-weight: 600; color: #111827; }

        @media (max-width: 991px) {
            .carousel-thumbnails { grid-template-columns: repeat(auto-fill, minmax(70px, 1fr)); gap: 0.5rem; }
        }
        @media (max-width: 575px) {
            .carousel-image-container { padding: 1rem; }
            .carousel-control-prev, .carousel-control-next { width: 32px; height: 32px; }
            .carousel-arrow { width: 16px; height: 16px; }
            .carousel-control-prev { left: 0.5rem; }
            .carousel-control-next { right: 0.5rem; }
            .carousel-thumbnails { grid-template-columns: repeat(auto-fill, minmax(60px, 1fr)); }
            .modal-close { top: 1rem; right: 1rem; font-size: 2.5rem; }
        }
    </style>

    <div class="container product-page py-4 py-md-5">
        {{-- TOP: карусель слева + инфо/спеки справа --}}
        <div class="row g-4 g-lg-5 align-items-stretch" id="topRow">
            <!-- Левая колонка -->
            <div class="col-lg-6" id="leftCol">
                @if ($product->images->count() > 0)
                    <div class="product-carousel-wrapper" id="mediaBox">
                        <div id="productCarousel" class="carousel slide">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="carousel-image-container" data-image="{{ asset('storage/' . $product->image) }}">
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                    </div>
                                </div>

                                @foreach ($product->images as $galleryImg)
                                    <div class="carousel-item">
                                        <div class="carousel-image-container" data-image="{{ asset('storage/' . $galleryImg->path) }}">
                                            <img src="{{ asset('storage/' . $galleryImg->path) }}" alt="{{ $product->name }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                                <svg class="carousel-arrow" fill="currentColor" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" />
                                </svg>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                                <svg class="carousel-arrow" fill="currentColor" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
                                </svg>
                            </button>
                        </div>

                        <div class="carousel-thumbnails">
                            <div class="thumbnail-item active" data-bs-target="#productCarousel" data-bs-slide-to="0">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="Miniatura">
                            </div>

                            @foreach ($product->images as $key => $galleryImg)
                                <div class="thumbnail-item" data-bs-target="#productCarousel" data-bs-slide-to="{{ $key + 1 }}">
                                    <img src="{{ asset('storage/' . $galleryImg->path) }}" alt="Miniatura">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="product-single-image" id="mediaBox">
                        <div class="carousel-image-container" data-image="{{ asset('storage/' . $product->image) }}">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                            @else
                                <div class="no-image text-center text-muted">
                                    <svg width="64" height="64" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                                        <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z" />
                                    </svg>
                                    <div>Brak zdjęcia</div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <!-- Правая колонка -->
            <div class="col-lg-6 d-flex" id="rightCol">
                <div class="d-flex flex-column w-100" id="rightBox">

                    {{-- Название/цена/кнопка — гармоничнее --}}
                    <div class="buy-card mb-3" id="buyBlock">
                        <h1 class="product-title">{{ $product->name }}</h1>

                        <div class="product-price">
                            {{ number_format($product->price, 2, ',', ' ') }} zł
                        </div>

                        <form action="{{ route('cart.add', $product) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-dark btn-lg w-100 border-0 shadow-sm">
                                <div class="fw-bold text-uppercase">
                                    <i class="bi bi-cart-plus me-2"></i> Dodaj do koszyka
                                </div>
                            </button>
                        </form>
                    </div>

                    {{-- Спецификация --}}
@if ($product->attributes->count() > 0)
    <div class="d-flex align-items-center justify-content-between mb-2" id="specHeader">
        <h2 class="h5 mb-0">Specyfikacja techniczna</h2>

        @if ($product->attributes->count() > 10)
            <button class="btn btn-outline-secondary btn-sm" type="button" id="toggleSpecsBtn">
                Rozwiń
            </button>
        @endif
    </div>

    <div class="spec-scroll" id="specsScroll">
        <table class="spec-table">
            @foreach ($product->attributes as $attribute)
                <tr class="spec-row">
                    <td class="spec-label">{{ $attribute->name }}</td>
                    <td class="spec-value">
                        {{ $attribute->pivot->value }}
                        @if ($attribute->unit) {{ $attribute->unit }} @endif
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
                    @else
                        <div class="alert alert-light border mb-0">Brak specyfikacji.</div>
                    @endif

                </div>
            </div>
        </div>

        {{-- Opis produktu (внизу на всю ширину) --}}
<div class="row mt-5">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <h2 class="h5 mb-0">Opis produktu</h2>
        </div>

        <div class="spec-scroll">
            <div class="p-3 p-md-4">
                {!! $product->description !!}
            </div>
        </div>
    </div>
</div>

        {{-- Админ-кнопки: Bootstrap utilities вместо кастомного CSS --}}
        @auth
            @if (auth()->user()->is_admin)
                <div class="position-fixed bottom-0 end-0 p-4 d-flex gap-2" style="z-index: 1000;">
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-secondary shadow-sm d-flex align-items-center gap-2">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10z" />
                        </svg>
                        Edytuj
                    </a>

                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                          onsubmit="return confirm('Czy na pewno chcesz usunąć ten produkt?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-warning shadow-sm d-flex align-items-center gap-2">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                            </svg>
                            Usuń
                        </button>
                    </form>
                </div>
            @endif
        @endauth

    </div>

    <!-- Модальное окно (твоё) -->
    <div id="imageModal" class="image-modal">
        <span class="modal-close">&times;</span>
        <img class="modal-content" id="modalImage">
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1) Миниатюры
            const myCarousel = document.getElementById('productCarousel');
            const thumbnails = document.querySelectorAll('.thumbnail-item');

            if (myCarousel) {
                myCarousel.addEventListener('slide.bs.carousel', function(event) {
                    const index = event.to;
                    thumbnails.forEach(thumb => thumb.classList.remove('active'));
                    if (thumbnails[index]) thumbnails[index].classList.add('active');
                });
            }

            // 2) Модалка изображений (твой код)
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');
            const imageContainers = document.querySelectorAll('.carousel-image-container');
            const closeBtn = document.querySelector('.modal-close');

            imageContainers.forEach(container => {
                container.style.cursor = 'zoom-in';
                container.addEventListener('click', function() {
                    const imgSrc = this.getAttribute('data-image');
                    modal.style.display = 'flex';
                    modalImg.src = imgSrc;
                    document.body.style.overflow = 'hidden';
                });
            });

            closeBtn?.addEventListener('click', closeModal);
            modal?.addEventListener('click', function(e) {
                if (e.target === modal) closeModal();
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && modal?.style.display === 'flex') closeModal();
            });

            function closeModal() {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }

            // 3) Высота спецификации = до низа левой колонки (только на lg+)
            const mediaBox = document.getElementById('mediaBox');
            const rightBox = document.getElementById('rightBox');
            const specsScroll = document.getElementById('specsScroll');
            const buyBlock = document.getElementById('buyBlock');
            const toggleBtn = document.getElementById('toggleSpecsBtn');

            let expanded = false;

            function syncSpecsHeight() {
                if (!mediaBox || !rightBox || !specsScroll || !buyBlock) return;

                const isLg = window.matchMedia('(min-width: 992px)').matches;
                if (!isLg) {
                    specsScroll.style.maxHeight = '';
                    rightBox.style.minHeight = '';
                    return;
                }

                if (expanded) return; // если раскрыто — не ограничиваем

                const leftHeight = mediaBox.offsetHeight; // карусель + миниатюры
                rightBox.style.minHeight = leftHeight + 'px';

                const buyHeight = buyBlock.offsetHeight;
                const gapReserve = 52; // запас на заголовок "Specyfikacja" + отступы
                const max = Math.max(160, leftHeight - buyHeight - gapReserve);
                specsScroll.style.maxHeight = max + 'px';
            }

            syncSpecsHeight();
            window.addEventListener('resize', syncSpecsHeight);

            // 4) Rozwiń/Zwiń для длинной таблицы
            if (toggleBtn && specsScroll) {
                toggleBtn.addEventListener('click', function() {
                    expanded = !expanded;
                    toggleBtn.textContent = expanded ? 'Zwiń' : 'Rozwiń';

                    if (expanded) {
                        specsScroll.style.maxHeight = '';
                        rightBox.style.minHeight = '';
                        // Можно дополнительно проскроллить к таблице, если хочешь:
                        // specsScroll.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    } else {
                        syncSpecsHeight();
                    }
                });
            }
        });
    </script>
@endsection
