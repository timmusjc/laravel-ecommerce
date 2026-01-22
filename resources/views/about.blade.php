@extends('layout')

@section('title', 'O nas - TEppLE')

@section('main_content')

<style>
/* ===================================
   ABOUT PAGE
   =================================== */

.about-page {
    background-color: #f9fafb;
    min-height: 100vh;
}

/* Hero Section */
.about-hero {
    background: linear-gradient(135deg, #111827 0%, #1f2937 100%);
    padding: 6rem 0 4rem;
    position: relative;
    overflow: hidden;
}

.about-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.05) 0%, transparent 50%),
        radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
}

.about-hero-content {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem;
    position: relative;
    z-index: 2;
    text-align: center;
}

.about-hero-title {
    font-size: 3.5rem;
    font-weight: 800;
    color: white;
    margin-bottom: 1.5rem;
    line-height: 1.2;
}

.about-hero-subtitle {
    font-size: 1.5rem;
    color: #d1d5db;
    max-width: 700px;
    margin: 0 auto;
    line-height: 1.6;
}

/* Content Sections */
.about-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 4rem 2rem;
}

.about-section {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 3rem;
    margin-bottom: 2rem;
}

.section-title {
    font-size: 2rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.section-title-icon {
    width: 40px;
    height: 40px;
    background: #111827;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.section-title-icon svg {
    width: 24px;
    height: 24px;
}

.section-text {
    font-size: 1.125rem;
    color: #4b5563;
    line-height: 1.8;
    margin-bottom: 1.5rem;
}

.section-text:last-child {
    margin-bottom: 0;
}

/* Values Grid */
.values-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

.value-card {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 2rem;
    transition: all 0.3s ease;
}

.value-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border-color: #111827;
}

.value-icon {
    width: 60px;
    height: 60px;
    background: #111827;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
}

.value-icon svg {
    width: 32px;
    height: 32px;
    color: white;
}

.value-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 0.75rem;
}

.value-description {
    font-size: 1rem;
    color: #6b7280;
    line-height: 1.6;
}

/* Team Grid */
.team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

.team-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
}

.team-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.team-avatar {
    width: 120px;
    height: 120px;
    background: linear-gradient(135deg, #111827 0%, #374151 100%);
    border-radius: 50%;
    margin: 0 auto 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    font-weight: 700;
    color: white;
}

.team-name {
    font-size: 1.25rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 0.5rem;
}

.team-role {
    font-size: 1rem;
    color: #6b7280;
    font-weight: 500;
}

/* Stats Section */
.stats-section {
    background: linear-gradient(135deg, #111827 0%, #1f2937 100%);
    border-radius: 12px;
    padding: 3rem;
    margin-bottom: 2rem;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 3rem;
    text-align: center;
}

.stat-item {
    padding: 1rem;
}

.stat-number {
    font-size: 3rem;
    font-weight: 800;
    color: white;
    line-height: 1;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 1rem;
    color: #d1d5db;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-weight: 600;
}

/* CTA Section */
.cta-section {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 3rem;
    text-align: center;
}

.cta-title {
    font-size: 2rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 1rem;
}

.cta-text {
    font-size: 1.125rem;
    color: #6b7280;
    margin-bottom: 2rem;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.cta-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.cta-btn {
    padding: 1rem 2.5rem;
    border-radius: 6px;
    font-size: 1rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.cta-btn-primary {
    background-color: #111827;
    color: white;
}

.cta-btn-primary:hover {
    background-color: #1f2937;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(17, 24, 39, 0.3);
}

.cta-btn-secondary {
    background-color: white;
    color: #111827;
    border: 2px solid #e5e7eb;
}

.cta-btn-secondary:hover {
    background-color: #f9fafb;
    color: #111827;
    border-color: #111827;
}

/* Responsive */
@media (max-width: 768px) {
    .about-hero {
        padding: 4rem 0 3rem;
    }
    
    .about-hero-title {
        font-size: 2.5rem;
    }
    
    .about-hero-subtitle {
        font-size: 1.25rem;
    }
    
    .about-section {
        padding: 2rem 1.5rem;
    }
    
    .section-title {
        font-size: 1.5rem;
    }
    
    .values-grid,
    .team-grid {
        grid-template-columns: 1fr;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .stat-number {
        font-size: 2.5rem;
    }
}

@media (max-width: 576px) {
    .about-container {
        padding: 2rem 1rem;
    }
    
    .cta-buttons {
        flex-direction: column;
    }
    
    .cta-btn {
        width: 100%;
        justify-content: center;
    }
}
</style>

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