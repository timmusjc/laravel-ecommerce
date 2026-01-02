@extends('layout')

@section('title')
    {{ $product->name }}
@endsection

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

/* Модальное окно для просмотра фото */
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
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.modal-content {
    max-width: 90%;
    max-height: 90%;
    width: auto;
    height: auto;
    object-fit: contain;
    animation: zoomIn 0.3s ease;
}

@keyframes zoomIn {
    from { transform: scale(0.8); }
    to { transform: scale(1); }
}

.modal-close {
    position: absolute;
    top: 2rem;
    right: 2rem;
    color: white;
    font-size: 3rem;
    font-weight: 300;
    cursor: pointer;
    transition: opacity 0.2s ease;
    line-height: 1;
    z-index: 10001;
}

.modal-close:hover {
    opacity: 0.7;
}

/* Адаптивность для карусели */
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
    
    .modal-close {
        top: 1rem;
        right: 1rem;
        font-size: 2.5rem;
    }
}
</style>

<div class="container product-page py-4 py-md-5">
    <div class="row g-4 g-lg-5">
        
        <!-- Левая колонка - Изображение/Карусель -->
        <div class="col-lg-6">
            @if($product->images->count() > 0)
                <!-- Карусель с несколькими фото -->
                <div class="product-carousel-wrapper">
                    <div id="productCarousel" class="carousel slide">
                        <div class="carousel-inner">
                            <!-- Главное фото -->
                            <div class="carousel-item active">
                                <div class="carousel-image-container" data-image="{{ asset('storage/' . $product->image) }}">
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->name }}">
                                </div>
                            </div>
                            <!-- Дополнительные фото -->
                            @foreach($product->images as $galleryImg)
                            <div class="carousel-item">
                                <div class="carousel-image-container" data-image="{{ asset('storage/' . $galleryImg->path) }}">
                                    <img src="{{ asset('storage/' . $galleryImg->path) }}" 
                                         alt="{{ $product->name }}">
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
                            <img src="{{ asset('storage/' . $product->image) }}" alt="Miniatura">
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
                    <div class="carousel-image-container" data-image="{{ asset('storage/' . $product->image) }}">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                        @else
                            <div class="no-image">
                                <svg width="64" height="64" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                    <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z"/>
                                </svg>
                                <div>Brak zdjęcia</div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Правая колонка - Информация -->
        <div class="col-lg-6">
            <div class="product-info">
                
                <!-- Название товара -->
                <h1 class="product-title">{{ $product->name }}</h1>
                
                <!-- Цена -->
                <div class="product-price">
                    {{ number_format($product->price, 2, ',', ' ') }} zł
                </div>
                
                 <!-- Кнопка добавления в корзину -->
                <form action="{{ route('cart.add', $product) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-dark btn-lg border-0 shadow-lg position-relative overflow-hidden">
                        
                    
                          
                            <div class="fw-bold text-uppercase">
                                <i class="bi bi-cart-plus me-2"></i> Dodaj do koszyka
                            </div>
                        
                    </button>
                </form>
                
                <!-- Описание товара -->
                <div class="product-description">
                    <h2 class="section-title">Opis produktu</h2>
                    <p class="description-text">{{ $product->description }}</p>
                </div>
                
                <!-- Спецификация -->
                @if($product->attributes->count() > 0)
                <div class="specifications">
                    <h2 class="section-title">Specyfikacja techniczna</h2>
                    <table class="spec-table">
                        @foreach($product->attributes as $attribute)
                        <tr class="spec-row">
                            <td class="spec-label">{{ $attribute->name }}</td>
                            <td class="spec-value">
                                {{ $attribute->pivot->value }}
                                @if($attribute->unit)
                                    {{ $attribute->unit }}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                @endif
                
            </div>
        </div>
        
    </div>
</div>

<!-- Модальное окно для просмотра фото -->
<div id="imageModal" class="image-modal">
    <span class="modal-close">&times;</span>
    <img class="modal-content" id="modalImage">
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. ЛОГИКА МИНИАТЮР (Исправленная)
    // Мы слушаем событие переключения карусели
    const myCarousel = document.getElementById('productCarousel');
    const thumbnails = document.querySelectorAll('.thumbnail-item');

    if (myCarousel) {
        myCarousel.addEventListener('slide.bs.carousel', function (event) {
            // Получаем индекс следующего слайда
            const index = event.to;
            
            // Убираем класс active у всех
            thumbnails.forEach(thumb => thumb.classList.remove('active'));
            
            // Добавляем класс active нужному
            if(thumbnails[index]) {
                thumbnails[index].classList.add('active');
            }
        });
    }

    // 2. МОДАЛЬНОЕ ОКНО
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');
    const imageContainers = document.querySelectorAll('.carousel-image-container');
    const closeBtn = document.querySelector('.modal-close');
    
    // Открытие модального окна
    imageContainers.forEach(container => {
        container.style.cursor = 'zoom-in';
        container.addEventListener('click', function() {
            const imgSrc = this.getAttribute('data-image');
            modal.style.display = 'flex';
            modalImg.src = imgSrc;
            document.body.style.overflow = 'hidden';
        });
    });
    
    // Закрытие модального окна
    closeBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', function(e) {
        if (e.target === modal) closeModal();
    });
    
    // Закрытие по ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.style.display === 'flex') {
            closeModal();
        }
    });

    function closeModal() {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
});
</script>
@endsection