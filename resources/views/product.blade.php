@extends('layout')

@section('title')
    {{ $product->name }}
@endsection

@section('main_content')

    

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
                                    <div class="carousel-image-container zoomable" data-image="{{ asset('storage/' . $product->image) }}">
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                    </div>
                                </div>

                                @foreach ($product->images as $galleryImg)
                                    <div class="carousel-item">
                                        <div class="carousel-image-container zoomable" data-image="{{ asset('storage/' . $galleryImg->path) }}">
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
                        <div class="carousel-image-container zoomable" data-image="{{ asset('storage/' . $product->image) }}">
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
                <div class="position-fixed bottom-0 end-0 p-4 d-flex gap-2 u-z-1000">
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
