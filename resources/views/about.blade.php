@extends('layout')

@section('title', 'O nas - TEppLE')

@section('main_content')



<div class="about-page">
    <!-- Hero Section -->
    <div class="about-hero">
        <div class="about-hero-content">
            <h1 class="about-hero-title">O nas</h1>
            <p class="about-hero-subtitle">
                Jesteśmy pasjonatami technologii, którzy wierzą, że każdy zasługuje na dostęp do najlepszej elektroniki
            </p>
        </div>
    </div>
    
    <div class="about-container">
        
        <!-- Nasza Historia -->
        <div class="about-section">
            <h2 class="section-title">
                <div class="section-title-icon">
                    <svg fill="currentColor" viewBox="0 0 16 16">
                        <path d="M1 11a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3zm5-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V2z"/>
                    </svg>
                </div>
                Nasza Historia
            </h2>
            <p class="section-text">
                TEppLE zostało założone z prostą misją - uczynić najnowszą technologię dostępną dla wszystkich. Od początku naszej drogi koncentrowaliśmy się na dostarczaniu produktów najwyższej jakości w konkurencyjnych cenach.
            </p>
            <p class="section-text">
                Dziś jesteśmy dumni z tego, że możemy służyć tysiącom zadowolonych klientów, oferując szeroki wybór elektroniki - od smartfonów po sprzęt komputerowy. Nasza pasja do technologii napędza nas każdego dnia do doskonalenia naszej oferty i obsługi.
            </p>
        </div>
        
        <!-- Statystyki -->
        <div class="stats-section">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">1000+</div>
                    <div class="stat-label">Zadowolonych klientów</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Produktów w ofercie</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">Wsparcie techniczne</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">100%</div>
                    <div class="stat-label">Gwarancja jakości</div>
                </div>
            </div>
        </div>
        
        <!-- Nasze Wartości -->
        <div class="about-section">
            <h2 class="section-title">
                <div class="section-title-icon">
                    <svg fill="currentColor" viewBox="0 0 16 16">
                        <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
                    </svg>
                </div>
                Nasze Wartości
            </h2>
            
            <div class="values-grid">
                <div class="value-card">
                    <div class="value-icon">
                        <svg fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                        </svg>
                    </div>
                    <h3 class="value-title">Jakość</h3>
                    <p class="value-description">
                        Oferujemy tylko oryginalne produkty od zaufanych producentów z pełną gwarancją
                    </p>
                </div>
                
                <div class="value-card">
                    <div class="value-icon">
                        <svg fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                        </svg>
                    </div>
                    <h3 class="value-title">Zaufanie</h3>
                    <p class="value-description">
                        Budujemy długoterminowe relacje oparte na uczciwości i transparentności
                    </p>
                </div>
                
                <div class="value-card">
                    <div class="value-icon">
                        <svg fill="currentColor" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                        </svg>
                    </div>
                    <h3 class="value-title">Innowacja</h3>
                    <p class="value-description">
                        Nieustannie poszukujemy nowości i ulepszeń dla naszych klientów
                    </p>
                </div>
                
                <div class="value-card">
                    <div class="value-icon">
                        <svg fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="value-title">Bezpieczeństwo</h3>
                    <p class="value-description">
                        Twoje dane i transakcje są chronione najnowszymi technologiami
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Nasz Zespół -->
        <div class="about-section">
            <h2 class="section-title">
                <div class="section-title-icon">
                    <svg fill="currentColor" viewBox="0 0 16 16">
                        <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
                    </svg>
                </div>
                Nasz Zespół
            </h2>
            
            <div class="team-grid">
                <div class="team-card">
                    <div class="team-avatar">AK</div>
                    <h3 class="team-name">Anna Kowalska</h3>
                    <p class="team-role">CEO & Założycielka</p>
                </div>
                
                <div class="team-card">
                    <div class="team-avatar">PN</div>
                    <h3 class="team-name">Piotr Nowak</h3>
                    <p class="team-role">Kierownik Działu Sprzedaży</p>
                </div>
                
                <div class="team-card">
                    <div class="team-avatar">MW</div>
                    <h3 class="team-name">Maria Wiśniewska</h3>
                    <p class="team-role">Specjalista ds. Obsługi Klienta</p>
                </div>
                
                <div class="team-card">
                    <div class="team-avatar">JK</div>
                    <h3 class="team-name">Jan Kowalczyk</h3>
                    <p class="team-role">Ekspert Techniczny</p>
                </div>
            </div>
        </div>
        
        <!-- CTA Section -->
        <div class="cta-section">
            <h2 class="cta-title">Gotowy na zakupy?</h2>
            <p class="cta-text">
                Dołącz do tysięcy zadowolonych klientów i odkryj naszą bogatą ofertę produktów elektronicznych
            </p>
            <div class="cta-buttons">
                <a href="{{ route('home') }}" class="cta-btn cta-btn-primary">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </svg>
                    Zobacz produkty
                </a>
                <a href="{{ route('home') }}#contact" class="cta-btn cta-btn-secondary">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z"/>
                    </svg>
                    Skontaktuj się
                </a>
            </div>
        </div>
        
    </div>
</div>

@endsection