@extends('layouts.soya')

@section('title', 'Söya. | prod. bistronippon 北と北')

@push('page-styles')
<script src="https://cdn.tailwindcss.com"></script>
<style>
    /* === モバイル専用上書き === */
    @@media (max-width: 767px) {
        body,
        .concrete-bg { background-color: #eaedf0 !important; }

        .global-header,
        .global-nav,
        .site-footer { display: none !important; }

        .main-container {
            padding: 0 !important;
            align-items: stretch !important;
            min-height: 0 !important;
        }
    }

    /* スクロールバー非表示 */
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    /* フェードイン アニメーション */
    .fade-in-section {
        opacity: 0;
        transform: translateY(12px);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }
    .fade-in-section.visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* 2回目以降の訪問: Intro を即スキップ */
    html.intro-skipped #intro-overlay {
        display: none !important;
        visibility: hidden !important;
    }
    html.intro-skipped .main-container {
        opacity: 1 !important;
    }

    /* Accès ボトムシート */
    .bottom-sheet-root {
        pointer-events: none;
        visibility: hidden;
    }
    .bottom-sheet-root.is-open {
        pointer-events: auto;
        visibility: visible;
    }
    .bottom-sheet-overlay {
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .bottom-sheet-root.is-open .bottom-sheet-overlay {
        opacity: 1;
    }
    .bottom-sheet-panel {
        transform: translateY(100%);
        transition: transform 0.35s cubic-bezier(0.32, 0.72, 0, 1);
    }
    .bottom-sheet-root.is-open .bottom-sheet-panel {
        transform: translateY(0);
    }

    /* Accès 固有 */
    #access-copy-toast {
        opacity: 0;
        transform: translateY(8px);
        transition: opacity 0.25s ease, transform 0.25s ease;
        pointer-events: none;
    }
    #access-copy-toast.is-visible {
        opacity: 1;
        transform: translateY(0);
    }

</style>
@endpush

@php
    $accessAddress = '38 Av. Salah Ben Youssef, Tunis 1013';
    $accessMapsUrl = 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode($accessAddress);
    $accessTel = config('services.takeout.tel', '+21624986077');
    $accessTelHref = 'tel:' . preg_replace('/[^\d+]/', '', $accessTel);
    $infoMapsShareUrl = 'https://share.google/AuyzAfsXz5CmrBywq';
    $infoInstagramUrl = 'https://www.instagram.com/soya.tunis/';
    $infoWhatsAppUrl = 'https://wa.me/21655778665';
@endphp

@section('content')
    {{-- 1. イントロ スプラッシュ（変更禁止） --}}
    @include('parts.intro')
    <script>
        (function() {
            try {
                if (localStorage.getItem('soya_intro_seen')) {
                    document.documentElement.classList.add('intro-skipped');
                }
            } catch (e) {}
        })();
    </script>

    {{-- 2. メインコンテナ --}}
    <div class="main-container" style="opacity:0;">

        {{-- === デスクトップ用（既存レイアウト 完全維持） === --}}
        <div class="hidden md:block w-full">
            <div class="content-wrapper">
                <div class="architectural-line d-none d-md-block"></div>
                <div class="row align-items-center">
                    <div class="col-lg-5 mb-5 mb-lg-0 text-center text-lg-start">
                        <p class="collab-text animate__animated animate__fadeIn">
                            Bistronippon <span style="font-size:0.8em; margin:0 5px;">→</span> Menzah 9
                        </p>
                        <h1 class="brand-title">Söya<span class="dot-highlight">.</span></h1>
                        <h2 class="brand-subtitle" id="subtitle"></h2>
                    </div>
                    <div class="col-lg-7">
                        <div class="story-text" id="story-content"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- === モバイル専用 Spotify型UI === --}}
        <div class="md:hidden flex flex-col w-full overflow-hidden"
             style="height: 100dvh; background-color: #eaedf0; color: #110A08;">

            {{-- TOP: ブランドヘッダー --}}
            <header class="shrink-0 flex items-center justify-between px-5 py-3 border-b"
                    style="background-color: #eaedf0; border-color: rgba(163,184,201,0.3);">
                <div>
                    <h1 style="font-family: 'Playfair Display', serif; font-size: 1.3rem;
                               font-weight: 700; letter-spacing: -0.02em; color: #110A08;">
                        Söya<span style="color: #e60012;">.</span>
                    </h1>
                    <p style="font-size: 0.6rem; letter-spacing: 0.2em;
                              color: #A3B8C9; margin-top: 1px;">
                        北 と 北
                    </p>
                </div>
                <a href="https://www.instagram.com/soya.tunis/"
                   target="_blank" rel="noopener noreferrer"
                   class="flex items-center justify-center w-9 h-9 rounded-full"
                   style="background: rgba(163,184,201,0.2);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                         viewBox="0 0 24 24" fill="none" stroke="#110A08"
                         stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                        <circle cx="12" cy="12" r="4"/>
                        <circle cx="17.5" cy="6.5" r="1" fill="#110A08" stroke="none"/>
                    </svg>
                </a>
            </header>

            {{-- MIDDLE: スクロールエリア --}}
            <main class="flex-1 overflow-y-auto overscroll-contain hide-scrollbar"
                  id="mobile-scroll-area"
                  style="-webkit-overflow-scrolling: touch;">

                {{-- A: クイックアクセス グリッド --}}
                <section class="fade-in-section px-4 pt-5 pb-2">
                    <div class="grid grid-cols-2 gap-2">

                        {{-- Menu --}}
                        <a href="https://soyam9.bistronippon.tn/menu/preview/soya"
                           class="flex items-center gap-3 rounded-lg overflow-hidden active:scale-95 transition-all duration-150"
                           style="background: #ffffff; border: 1px solid rgba(163,184,201,0.2); box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
                            <img src="https://images.unsplash.com/photo-1617093727343-374698b1b08d?w=400&q=80"
                                 alt="Menu" class="w-12 h-12 object-cover shrink-0">
                            <span style="font-size: 0.8rem; font-weight: 700; color: #110A08; letter-spacing: 0.01em;">Menu</span>
                        </a>

                        {{-- Reservation --}}
                        <a href="https://soyam9.bistronippon.tn/reservation"
                           class="flex items-center gap-3 rounded-lg overflow-hidden active:scale-95 transition-all duration-150"
                           style="background: #ffffff; border: 1px solid rgba(163,184,201,0.2); box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
                            <img src="{{ asset('images/rsrv.jpg') }}"
                                 alt="Réservation" class="w-12 h-12 object-cover shrink-0">
                            <span style="font-size: 0.7rem; font-weight: 700; color: #110A08; letter-spacing: 0.01em;">Booking</span>
                        </a>

                        {{-- Access --}}
                        <button type="button" onclick="openAccessSheet()"
                                class="flex items-center gap-3 rounded-lg overflow-hidden active:scale-95 transition-all duration-150 text-left w-full"
                                style="background: #ffffff; border: 1px solid rgba(163,184,201,0.2); box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
                            <div class="w-12 h-12 shrink-0 flex items-center justify-center"
                                 style="background: rgba(230,0,18,0.08);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                     viewBox="0 0 24 24" fill="none" stroke="#e60012"
                                     stroke-width="1.5" stroke-linecap="round">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                                    <circle cx="12" cy="9" r="2.5"/>
                                </svg>
                            </div>
                            <span style="font-size: 0.8rem; font-weight: 700; color: #110A08; letter-spacing: 0.01em;">Accès</span>
                        </button>

                        {{-- Instagram --}}
                        <a href="https://www.instagram.com/soya.tunis/"
                           target="_blank" rel="noopener noreferrer"
                           class="flex items-center gap-3 rounded-lg overflow-hidden active:scale-95 transition-all duration-150"
                           style="background: #ffffff; border: 1px solid rgba(163,184,201,0.2); box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
                            <div class="w-12 h-12 shrink-0 flex items-center justify-center"
                                 style="background: rgba(163,184,201,0.15);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                     viewBox="0 0 24 24" fill="none" stroke="#110A08"
                                     stroke-width="1.5" stroke-linecap="round">
                                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                                    <circle cx="12" cy="12" r="4"/>
                                    <circle cx="17.5" cy="6.5" r="1" fill="#110A08" stroke="none"/>
                                </svg>
                            </div>
                            <span style="font-size: 0.7rem; font-weight: 700; color: #110A08; letter-spacing: 0.01em;">Instagram</span>
                        </a>

                        {{-- Notre Histoire --}}
                        <button type="button" onclick="document.getElementById('story-section').scrollIntoView({behavior:'smooth'})"
                                class="flex items-center gap-3 rounded-lg overflow-hidden active:scale-95 transition-all duration-150 text-left w-full"
                                style="background: #ffffff; border: 1px solid rgba(163,184,201,0.2); box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
                            <img src="{{ asset('images/story.png') }}"
                                 alt="Notre Histoire" class="w-12 h-12 object-cover shrink-0">
                            <span style="font-size: 0.8rem; font-weight: 700; color: #110A08; letter-spacing: 0.01em;">Story</span>
                        </button>

                        {{-- Contact → INFO Contact & SNS へスクロール --}}
                        <button type="button" onclick="document.getElementById('info-contact').scrollIntoView({behavior:'smooth'})"
                                class="flex items-center gap-3 rounded-lg overflow-hidden active:scale-95 transition-all duration-150 text-left w-full"
                                style="background: #ffffff; border: 1px solid rgba(163,184,201,0.2); box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
                            <div class="w-12 h-12 shrink-0 flex items-center justify-center"
                                 style="background: rgba(37,211,102,0.12);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                     viewBox="0 0 24 24" fill="#25D366">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.123 1.035 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.435 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                            </div>
                            <span style="font-size: 0.8rem; font-weight: 700; color: #110A08; letter-spacing: 0.01em;">Contact</span>
                        </button>

                    </div>
                </section>

                {{-- B: フィーチャーバナー（横スクロール） --}}
                <section class="fade-in-section px-4 pt-6">
                    <h2 style="font-size: 0.65rem; font-weight: 700; color: #A3B8C9;
                               letter-spacing: 0.2em; text-transform: uppercase; margin-bottom: 0.75rem;">
                        Incontournables
                    </h2>
                    <div class="flex gap-3 overflow-x-auto hide-scrollbar pb-2">

                        @php
                        $features = [
                            ['img' => 'https://images.unsplash.com/photo-1569050467447-ce54b3bbc37d?w=400&q=80',
                             'name' => 'Ramen Tokyo', 'sub' => 'Sauce soja, chashu maison'],
                            ['img' => 'https://images.unsplash.com/photo-1617093727343-374698b1b08d?w=400&q=80',
                             'name' => 'Gyoza du Moment', 'sub' => 'Croustillant, sauce yuzu'],
                            ['img' => 'https://images.unsplash.com/photo-1547592180-85f173990554?w=400&q=80',
                             'name' => 'Curry Ramen', 'sub' => 'Épicé, onctueux'],
                            ['img' => 'https://images.unsplash.com/photo-1591814468924-caf88d1232e1?w=400&q=80',
                             'name' => 'Mazé Ramen', 'sub' => 'Sans bouillon, signature'],
                        ];
                        @endphp

                        @foreach ($features as $item)
                        <div class="shrink-0 w-36 cursor-pointer active:scale-95 transition-all duration-150">
                            <div class="w-36 h-36 rounded-xl overflow-hidden mb-2">
                                <img src="{{ $item['img'] }}" alt="{{ $item['name'] }}"
                                     class="w-full h-full object-cover">
                            </div>
                            <p style="font-size: 0.8rem; font-weight: 700; color: #110A08; line-height: 1.2;">
                                {{ $item['name'] }}
                            </p>
                            <p style="font-size: 0.7rem; color: #A3B8C9; margin-top: 2px; line-height: 1.2;">
                                {{ $item['sub'] }}
                            </p>
                        </div>
                        @endforeach

                    </div>
                </section>

                {{-- C: ブランドストーリー --}}
                <section id="story-section" class="fade-in-section px-4 pt-6 pb-8">
                    <h2 style="font-size: 0.65rem; font-weight: 700; color: #A3B8C9;
                               letter-spacing: 0.2em; text-transform: uppercase; margin-bottom: 0.75rem;">
                        Sto
                    </h2>

                    {{-- 言語切替ボタン --}}
                    <div class="flex gap-2 mb-4">
                        @foreach(['en' => 'EN', 'fr' => 'FR', 'jp' => 'JP'] as $code => $label)
                        <button class="lang-btn px-3 py-1 rounded-full text-xs font-bold transition-all duration-200 active:scale-95"
                                data-lang="{{ $code }}"
                                style="background: rgba(163,184,201,0.15);
                                       color: #A3B8C9;
                                       border: 1px solid rgba(163,184,201,0.3);">
                            {{ $label }}
                        </button>
                        @endforeach
                    </div>

                    <div class="rounded-2xl p-5"
                         style="background: #ffffff; border: 1px solid rgba(163,184,201,0.3);">
                        <h3 id="mobile-subtitle"
                            style="font-family: 'Playfair Display', serif; font-size: 1.1rem;
                                   font-weight: 700; color: #110A08; margin-bottom: 1rem; line-height: 1.4;">
                        </h3>
                        <div id="mobile-story-content"
                             style="font-size: 0.8rem; color: #110A08; opacity: 0.8; line-height: 1.8;">
                        </div>
                    </div>
                </section>

                {{-- D: Infos (Bento UI) --}}
                <section id="info-section" class="fade-in-section px-4 pt-2 pb-10">
                    <h2 style="font-size: 0.65rem; font-weight: 700; color: #A3B8C9;
                               letter-spacing: 0.2em; text-transform: uppercase; margin-bottom: 0.75rem;">
                        Infos
                    </h2>

                    <div class="flex flex-col gap-3">

                        {{-- 1. Horaires --}}
                        <div class="rounded-2xl p-4"
                             style="background: #ffffff; border: 1px solid rgba(163,184,201,0.3);">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold tracking-wide mb-3"
                                  style="background: rgba(163,184,201,0.15); color: #A3B8C9; border: 1px solid rgba(163,184,201,0.3);">
                                🔴 Ouverture prochainement (Spring 2026)
                            </span>
                            <p class="text-sm font-bold mb-1" style="color: #110A08;">Horaires</p>
                            <ul class="space-y-2" style="font-size: 0.8rem; color: #110A08; line-height: 1.5;">
                                <li>
                                    <span class="font-semibold" style="color: #A3B8C9;">Mar – Dim</span>
                                    <span class="block mt-0.5">12h00 – 15h00 | 18h30 – 22h15</span>
                                </li>
                                <li>
                                    <span class="font-semibold" style="color: #A3B8C9;">Lun</span>
                                    <span class="block mt-0.5 font-semibold" style="color: #A3B8C9;">Fermé</span>
                                </li>
                            </ul>
                        </div>

                        {{-- 2. Accès --}}
                        <div class="rounded-2xl p-4"
                             style="background: #ffffff; border: 1px solid rgba(163,184,201,0.3);">
                            <p class="text-sm font-bold mb-2" style="color: #110A08;">Accès</p>
                            <p class="text-sm mb-3" style="color: #110A08; opacity: 0.85; line-height: 1.5;">
                                {{ $accessAddress }}
                            </p>
                            <a href="{{ $infoMapsShareUrl }}"
                               target="_blank" rel="noopener noreferrer"
                               class="flex items-center justify-center gap-2 w-full py-3 rounded-xl text-sm font-bold text-white active:scale-95 transition-transform duration-150"
                               style="background-color: #e60012;">
                                📍 Ouvrir dans Google Maps
                            </a>
                        </div>

                        {{-- 3. Contact & SNS --}}
                        <div id="info-contact" class="rounded-2xl p-4"
                             style="background: #ffffff; border: 1px solid rgba(163,184,201,0.3);">
                            <p class="text-sm font-bold mb-3" style="color: #110A08;">Contact &amp; SNS</p>
                            <div class="grid grid-cols-3 gap-2">
                                <a href="{{ $accessTelHref }}"
                                   class="flex flex-col items-center justify-center gap-1.5 py-3 rounded-xl active:scale-95 transition-transform duration-150"
                                   style="background: rgba(163,184,201,0.12); border: 1px solid rgba(163,184,201,0.25);">
                                    <span class="w-9 h-9 rounded-full flex items-center justify-center shrink-0"
                                          style="background: rgba(163,184,201,0.15);">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                             fill="none" stroke="#110A08" stroke-width="1.8" stroke-linecap="round">
                                            <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.8 19.79 19.79 0 01.15 1.19 2 2 0 012.11 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92v2z"/>
                                        </svg>
                                    </span>
                                    <span class="text-[10px] font-bold tracking-wide" style="color: #110A08;">TEL</span>
                                </a>
                                <a href="{{ $infoWhatsAppUrl }}"
                                   target="_blank" rel="noopener noreferrer"
                                   class="flex flex-col items-center justify-center gap-1.5 py-3 rounded-xl active:scale-95 transition-transform duration-150"
                                   style="background: rgba(37,211,102,0.1); border: 1px solid rgba(37,211,102,0.25);">
                                    <span class="w-9 h-9 rounded-full flex items-center justify-center shrink-0"
                                          style="background: rgba(37,211,102,0.12);">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="#25D366">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.123 1.035 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.435 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                        </svg>
                                    </span>
                                    <span class="text-[10px] font-bold tracking-wide" style="color: #110A08;">WA</span>
                                </a>
                                <a href="{{ $infoInstagramUrl }}"
                                   target="_blank" rel="noopener noreferrer"
                                   class="flex flex-col items-center justify-center gap-1.5 py-3 rounded-xl active:scale-95 transition-transform duration-150"
                                   style="background: rgba(163,184,201,0.12); border: 1px solid rgba(163,184,201,0.25);">
                                    <span class="w-9 h-9 rounded-full flex items-center justify-center shrink-0"
                                          style="background: rgba(163,184,201,0.15);">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                             fill="none" stroke="#110A08" stroke-width="1.8" stroke-linecap="round">
                                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                                            <circle cx="12" cy="12" r="4"/>
                                            <circle cx="17.5" cy="6.5" r="1" fill="#110A08" stroke="none"/>
                                        </svg>
                                    </span>
                                    <span class="text-[10px] font-bold tracking-wide" style="color: #110A08;">INSTA</span>
                                </a>
                            </div>
                        </div>

                    </div>
                </section>

            </main>{{-- end MIDDLE --}}

            {{-- BOTTOM: 固定タブバー --}}
            <nav class="shrink-0 flex items-center justify-around px-2 py-2"
                 style="background: #ffffff; border-top: 1px solid rgba(163,184,201,0.3); height: 60px;">

                <button onclick="document.getElementById('mobile-scroll-area').scrollTo({top:0,behavior:'smooth'})"
                        class="flex flex-col items-center gap-0.5 px-3 nav-tab active-tab">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.5" stroke-linecap="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                    <span style="font-size: 0.55rem; font-weight: 600; letter-spacing: 0.05em;">HOME</span>
                </button>

                <a href="https://soyam9.bistronippon.tn/menu/preview/soya"
                   class="flex flex-col items-center gap-0.5 px-3 nav-tab"
                   style="color: #A3B8C9;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.5" stroke-linecap="round">
                        <rect x="3" y="3" width="18" height="4" rx="1"/>
                        <rect x="3" y="9" width="18" height="4" rx="1"/>
                        <rect x="3" y="15" width="18" height="4" rx="1"/>
                    </svg>
                    <span style="font-size: 0.55rem; font-weight: 600; letter-spacing: 0.05em;">MENU</span>
                </a>

                <a href="https://soyam9.bistronippon.tn/reservation"
                   class="flex flex-col items-center gap-0.5 px-3 nav-tab"
                   style="color: #A3B8C9;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.5" stroke-linecap="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    <span style="font-size: 0.55rem; font-weight: 600; letter-spacing: 0.05em;">RÉSERVER</span>
                </a>

                <button type="button" onclick="document.getElementById('info-section').scrollIntoView({behavior:'smooth'})"
                        class="flex flex-col items-center gap-0.5 px-3 nav-tab"
                        style="color: #A3B8C9;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.5" stroke-linecap="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <span style="font-size: 0.55rem; font-weight: 600; letter-spacing: 0.05em;">INFO</span>
                </button>

            </nav>

        </div>{{-- end モバイル専用 --}}

    </div>{{-- end .main-container --}}

    {{-- Accès ボトムシート（モバイルのみ） --}}
    <div id="access-sheet-root" class="bottom-sheet-root md:hidden fixed inset-0 z-[60]" aria-hidden="true" role="dialog" aria-labelledby="access-sheet-title">
        <div id="access-sheet-overlay" class="bottom-sheet-overlay absolute inset-0 bg-black/50" onclick="closeAccessSheet()" aria-hidden="true"></div>

        <div id="access-sheet-panel"
             class="bottom-sheet-panel absolute bottom-0 inset-x-0 bg-white rounded-t-3xl shadow-[0_-8px_30px_rgba(0,0,0,0.12)] max-h-[70vh] overflow-y-auto overscroll-contain"
             onclick="event.stopPropagation()">
            <div class="flex flex-col items-center pt-3 pb-2 px-6">
                <button type="button" onclick="closeAccessSheet()" class="w-10 h-1 rounded-full mb-3" style="background: rgba(163,184,201,0.5);" aria-label="Fermer"></button>
                <h2 id="access-sheet-title" class="w-full text-left font-bold text-lg mb-4" style="color: #110A08; font-family: 'Playfair Display', serif;">
                    Accès — Söya.
                </h2>

                <div class="w-full bg-gray-200 rounded-xl h-40 relative flex items-center justify-center overflow-hidden mb-5">
                    <a href="{{ $accessMapsUrl }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-bold text-white active:scale-95 transition-transform"
                       style="background-color: #e60012;">
                        📍 Ouvrir dans Google Maps
                    </a>
                </div>

                <div class="w-full grid grid-cols-3 gap-4 mb-5">
                    <a href="{{ $accessMapsUrl }}" target="_blank" rel="noopener noreferrer"
                       class="flex flex-col items-center gap-2 active:scale-95 transition-transform">
                        <span class="w-14 h-14 rounded-full flex items-center justify-center text-xl"
                              style="background: rgba(230,0,18,0.1);">🧭</span>
                        <span class="text-[10px] font-bold text-center" style="color: #110A08;">Y Aller</span>
                    </a>
                    <a href="{{ $accessTelHref }}"
                       class="flex flex-col items-center gap-2 active:scale-95 transition-transform">
                        <span class="w-14 h-14 rounded-full flex items-center justify-center text-xl"
                              style="background: rgba(163,184,201,0.2);">📞</span>
                        <span class="text-[10px] font-bold text-center" style="color: #110A08;">Appeler</span>
                    </a>
                    <button type="button" id="access-copy-btn" onclick="copyAccessAddress()"
                            class="flex flex-col items-center gap-2 active:scale-95 transition-transform">
                        <span class="w-14 h-14 rounded-full flex items-center justify-center text-xl"
                              style="background: rgba(163,184,201,0.2);">📋</span>
                        <span id="access-copy-label" class="text-[10px] font-bold text-center" style="color: #110A08;">Copier</span>
                    </button>
                </div>

                <p class="w-full text-sm leading-relaxed mb-6" style="color: #110A08;">
                    {{ $accessAddress }}
                </p>
            </div>
        </div>

        <div id="access-copy-toast"
             class="fixed left-1/2 -translate-x-1/2 bottom-[72vh] px-4 py-2 rounded-full text-xs font-bold text-white shadow-lg z-[61]"
             style="background-color: #110A08;">
            Copié !
        </div>
    </div>

@endsection

@push('scripts')
    <script type="module">
        $(function() {
            // --- 1. Content Data ---
            const contentData = {
                'en': {
                    subtitle: `North and North<br><span style="font-weight:300; opacity:0.7; margin-right:6px;">×</span>Tokyo Current`,
                    body: `
                        <p><strong>"Söya." bears a double essence.</strong></p>
                        <p>Firstly, it pays homage to <strong>Cape Soya</strong>, the northernmost point of Japan. Like Tunisia, the northern tip of Africa, we bridge these two ends of the world.</p>
                        <p>Secondly, it signifies <strong>Soya</strong> (Soybean), the soul of Japanese cuisine and the source of Umami.</p>
                        <p>The final period <strong>"."</strong> marks a destination where you can casually stop by in your daily life.</p>
                        <hr style="border:0; border-top:1px solid rgba(0,0,0,0.1); margin: 30px 0;">
                        <p>Tokyo’s food scene evolves every time I visit.</p>
                        <p>We’ve casually updated Bistro Nippon’s recipes to capture that "Tokyo Current" vibe.</p>
                        <p>Located in Menzah 9, <strong>Söya.</strong> is your new everyday spot for handmade ramen.</p>
                        <p style="margin-top:20px; font-weight:600; font-size: 0.9em; letter-spacing: 0.1em;">Opening this Spring.</p>
                    `,
                    footer: "Follow us on Instagram"
                },
                'fr': {
                    subtitle: `Nord et Nord<br><span style="display:block; margin-top:10px;"><span style="font-weight:300; opacity:0.7; margin-right:6px;">×</span>Tokyo Actuel</span>`,
                    body: `
                        <p><strong>"Söya." porte une double essence.</strong></p>
                        <p>Premièrement, un hommage au <strong>Cap Soya</strong>, l'extrême nord du Japon. Comme la Tunisie, nous relions deux extrémités du monde.</p>
                        <p>Deuxièmement, le <strong>Soya</strong> (Soja), l'âme de la cuisine japonaise et la source de l'Umami.</p>
                        <p>Le point final <strong>"."</strong> marque une destination où vous pouvez faire une halte spontanée dans votre quotidien.</p>
                        <hr style="border:0; border-top:1px solid rgba(0,0,0,0.1); margin: 30px 0;">
                        <p>Les tendances culinaires à Tokyo évoluent à chaque visite.</p>
                        <p>Nous avons remis au goût du jour les ramens du Bistro Nippon, avec une touche "Tokyo Actuel" décontractée.</p>
                        <p>Situé à Menzah 9, <strong>Söya.</strong> est votre nouvelle adresse quotidienne pour des ramens faits main.</p>
                        <p style="margin-top:20px; font-weight:600; font-size: 0.9em; letter-spacing: 0.1em;">Ouverture ce printemps.</p>
                    `,
                    footer: "Suivez-nous sur Instagram"
                },
                'jp': {
                    subtitle: `北と北<br><span style="font-weight:300; opacity:0.7; margin-right:6px;">×</span>Tokyo Current`,
                    body: `
                        <p><strong>「Söya.」が宿す、二つの本質。</strong></p>
                        <p>一つは、日本の最北端<strong>「宗谷岬」</strong>へのオマージュ。アフリカの最北端・チュニジアと同じく、世界の「北と北」を結びます。</p>
                        <p>もう一つは、日本食の魂であり、旨味の源である<strong>「大豆（Soya）」</strong>。</p>
                        <p>名前の最後にあるピリオド<strong>「.」</strong>は日常の中でふらっと立ち止まれる目的地。</p>
                        <hr style="border:0; border-top:1px solid rgba(0,0,0,0.1); margin: 30px 0;">
                        <p>毎年帰るたびに新しい発見がある、東京の食トレンド。</p>
                        <p>Bistro Nipponのラーメンを、今の東京っぽくさらりとアップデートしました。</p>
                        <p>Menzah 9にできる『Söya.』は、そんな普段使いの手打ちラーメン屋です。</p>
                        <p style="margin-top:20px; font-weight:600; font-size: 0.9em; letter-spacing: 0.1em;">この春、お待ちしています。</p>
                    `,
                    footer: "Instagramをフォローする"
                }
            };

            const $story = $('#story-content');
            const $subtitle = $('#subtitle');
            const $footerText = $('#footer-text');
            const $overlay = $('#intro-overlay');
            const $mainElements = $('.main-container, .global-nav, .site-footer');
            const $mobileSubtitle = $('#mobile-subtitle');
            const $mobileStory = $('#mobile-story-content');

            // --- 2. Language Setup ---
            const browserLang = navigator.language || navigator.userLanguage;
            const langCode = browserLang.substring(0, 2).toLowerCase();
            let currentLang = (langCode === 'ja') ? 'jp' : (langCode === 'fr' ? 'fr' : 'en');

            const updateContent = (lang) => {
                $subtitle.html(contentData[lang].subtitle).css('opacity', 1);
                $story.html(contentData[lang].body).css('opacity', 1);
                $footerText.text(contentData[lang].footer);
                $('.lang-btn').removeClass('active');
                $(`.lang-btn[data-lang="${lang}"]`).addClass('active');

                // モバイル用ミラー更新
                $mobileSubtitle.html(contentData[lang].subtitle);
                $mobileStory.html(contentData[lang].body);

                // アクティブ言語ボタンのスタイル更新
                $('.lang-btn').each(function() {
                    const isActive = $(this).data('lang') === lang;
                    $(this).css({
                        'background': isActive ? '#110A08' : 'rgba(163,184,201,0.15)',
                        'color': isActive ? '#ffffff' : '#A3B8C9',
                        'border-color': isActive ? '#110A08' : 'rgba(163,184,201,0.3)'
                    });
                });
            };

            updateContent(currentLang);

            // --- 3. Intro Animation（初回訪問のみ） ---
            const INTRO_KEY = 'soya_intro_seen';

            const dismissIntro = (animated) => {
                if (animated) {
                    $overlay.addClass('fade-out');
                    setTimeout(() => {
                        $overlay.hide();
                        $mainElements.css('opacity', 1);
                    }, 800);
                } else {
                    $overlay.hide();
                    $mainElements.css('opacity', 1);
                }
            };

            if (localStorage.getItem(INTRO_KEY)) {
                document.documentElement.classList.add('intro-skipped');
                dismissIntro(false);
            } else {
                setTimeout(() => $('#intro-1').addClass('fade-up'), 500);
                setTimeout(() => $('#intro-2').addClass('fade-up'), 1500);
                setTimeout(() => $('#intro-3').addClass('fade-up'), 2500);
                setTimeout(() => $('#intro-action').addClass('fade-up'), 3500);

                $('#enter-btn').on('click', function() {
                    try {
                        localStorage.setItem(INTRO_KEY, '1');
                    } catch (e) {}
                    dismissIntro(true);
                });
            }

            // --- 4. Language Switch ---
            $(document).on('click', '.lang-btn', function() {
                const lang = $(this).data('lang');
                $story.css('opacity', 0);
                $subtitle.css('opacity', 0);
                setTimeout(() => updateContent(lang), 400);
            });
        });

        // フェードイン（モバイル用）
        document.addEventListener('DOMContentLoaded', () => {
            const fadeEls = document.querySelectorAll('.fade-in-section');
            if (!fadeEls.length) return;

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });

            fadeEls.forEach(el => observer.observe(el));

            // アクティブタブ スタイル初期化
            document.querySelectorAll('.nav-tab').forEach(tab => {
                tab.style.color = '#A3B8C9';
            });
            const firstTab = document.querySelector('.nav-tab.active-tab');
            if (firstTab) firstTab.style.color = '#110A08';
        });

        // --- Accès ボトムシート ---
        const ACCESS_ADDRESS = @json($accessAddress);
        const accessSheetRoot = document.getElementById('access-sheet-root');
        let copyLabelResetTimer = null;

        window.openAccessSheet = function() {
            if (!accessSheetRoot) return;
            accessSheetRoot.classList.add('is-open');
            accessSheetRoot.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        };

        window.closeAccessSheet = function() {
            if (!accessSheetRoot) return;
            accessSheetRoot.classList.remove('is-open');
            accessSheetRoot.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
            hideAccessCopyToast();
        };

        window.copyAccessAddress = async function() {
            const label = document.getElementById('access-copy-label');
            try {
                if (navigator.clipboard?.writeText) {
                    await navigator.clipboard.writeText(ACCESS_ADDRESS);
                } else {
                    const ta = document.createElement('textarea');
                    ta.value = ACCESS_ADDRESS;
                    ta.setAttribute('readonly', '');
                    ta.style.position = 'fixed';
                    ta.style.left = '-9999px';
                    document.body.appendChild(ta);
                    ta.select();
                    document.execCommand('copy');
                    document.body.removeChild(ta);
                }
                if (label) label.textContent = 'Copié !';
                showAccessCopyToast();
                clearTimeout(copyLabelResetTimer);
                copyLabelResetTimer = setTimeout(() => {
                    if (label) label.textContent = 'Copier';
                }, 2000);
            } catch (e) {
                if (label) label.textContent = 'Erreur';
                copyLabelResetTimer = setTimeout(() => {
                    if (label) label.textContent = 'Copier';
                }, 2000);
            }
        };

        function showAccessCopyToast() {
            const toast = document.getElementById('access-copy-toast');
            if (toast) toast.classList.add('is-visible');
            clearTimeout(window._accessToastTimer);
            window._accessToastTimer = setTimeout(hideAccessCopyToast, 2000);
        }

        function hideAccessCopyToast() {
            const toast = document.getElementById('access-copy-toast');
            if (toast) toast.classList.remove('is-visible');
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && accessSheetRoot?.classList.contains('is-open')) {
                closeAccessSheet();
            }
        });
    </script>
@endpush
