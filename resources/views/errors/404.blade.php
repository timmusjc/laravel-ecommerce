@extends('layout')

@section('title', '404 - Strona nie znaleziona')

@section('main_content')

    <style>
        .error-page {
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background: linear-gradient(135deg, #f9fafb 0%, #e5e7eb 100%);
        }

        .error-container {
            text-align: center;
            max-width: 600px;
        }

        .error-code {
            font-size: 8rem;
            font-weight: 800;
            color: #111827;
            line-height: 1;
            margin-bottom: 1rem;
            text-shadow: 4px 4px 0px #e5e7eb;
        }

        .error-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 2rem;
            color: #6b7280;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .error-title {
            font-size: 2rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 1rem;
        }

        .error-text {
            font-size: 1.125rem;
            color: #6b7280;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .error-links {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .error-btn {
            padding: 0.875rem 2rem;
            border-radius: 6px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .error-btn-primary {
            background-color: #111827;
            color: white;
        }

        .error-btn-primary:hover {
            background-color: #1f2937;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(17, 24, 39, 0.3);
        }

        .error-btn-secondary {
            background-color: white;
            color: #111827;
            border: 2px solid #e5e7eb;
        }

        .error-btn-secondary:hover {
            background-color: #f9fafb;
            color: #111827;
            border-color: #111827;
        }

        .error-suggestions {
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid #e5e7eb;
        }

        .suggestions-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 1rem;
        }

        .suggestions-list {
            display: flex;
            gap: 0.75rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .suggestion-link {
            padding: 0.5rem 1rem;
            background-color: white;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            color: #374151;
            text-decoration: none;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .suggestion-link:hover {
            background-color: #f9fafb;
            color: #111827;
            border-color: #9ca3af;
        }

        @media (max-width: 576px) {
            .error-code {
                font-size: 5rem;
            }

            .error-icon {
                width: 80px;
                height: 80px;
            }

            .error-title {
                font-size: 1.5rem;
            }

            .error-text {
                font-size: 1rem;
            }

            .error-links {
                flex-direction: column;
            }

            .error-btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <div class="error-page">
        <div class="error-container">
            <svg class="error-icon" fill="currentColor" viewBox="0 0 16 16">
                <path
                    d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
            </svg>
            <div class="error-code">404</div>

            <h1 class="error-title">Strona nie została znaleziona</h1>

            <p class="error-text">
                Strona której szukasz nie istnieje lub została przeniesiona.
                Sprawdź adres URL lub wróć do strony głównej.
            </p>

            <div class="error-links">
                <a href="{{ route('home') }}" class="error-btn error-btn-primary">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5ZM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5 5 5Z" />
                    </svg>
                    Strona główna
                </a>

                <a href="javascript:history.back()" class="error-btn error-btn-secondary">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                    </svg>
                    Wróć
                </a>
            </div>



        </div>
    </div>

@endsection
