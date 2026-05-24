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
</style>
@endpush

@section('content')
    {{-- 1. イントロ スプラッシュ（変更禁止） --}}
    @include('parts.intro')

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
                        <a href="{{ url('/menu') }}"
                           class="flex items-center gap-3 rounded-lg overflow-hidden active:scale-95 transition-all duration-150"
                           style="background: #ffffff; border: 1px solid rgba(163,184,201,0.2); box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
                            <img src="https://images.unsplash.com/photo-1569050467447-ce54b3bbc37d?w=100&q=80"
                                 alt="Menu" class="w-12 h-12 object-cover shrink-0">
                            <span style="font-size: 0.8rem; font-weight: 700; color: #110A08; letter-spacing: 0.01em;">Menu</span>
                        </a>

                        {{-- Reservation --}}
                        <a href="https://soyam9.bistronippon.tn/reservation"
                           class="flex items-center gap-3 rounded-lg overflow-hidden active:scale-95 transition-all duration-150"
                           style="background: #ffffff; border: 1px solid rgba(163,184,201,0.2); box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
                            <img src="https://images.unsplash.com/photo-1617093727343-374698b1b08d?w=100&q=80"
                                 alt="Reservation" class="w-12 h-12 object-cover shrink-0">
                            <span style="font-size: 0.8rem; font-weight: 700; color: #110A08; letter-spacing: 0.01em;">Réservation</span>
                        </a>

                        {{-- Access --}}
                        <a href="https://maps.google.com/?q=Söya+Menzah+9+Tunis"
                           target="_blank" rel="noopener noreferrer"
                           class="flex items-center gap-3 rounded-lg overflow-hidden active:scale-95 transition-all duration-150"
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
                        </a>

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
                            <span style="font-size: 0.8rem; font-weight: 700; color: #110A08; letter-spacing: 0.01em;">Instagram</span>
                        </a>

                        {{-- Story --}}
                        <button onclick="document.getElementById('story-section').scrollIntoView({behavior:'smooth'})"
                                class="flex items-center gap-3 rounded-lg overflow-hidden active:scale-95 transition-all duration-150 text-left w-full"
                                style="background: #ffffff; border: 1px solid rgba(163,184,201,0.2); box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
                            <img src="https://images.unsplash.com/photo-1547592180-85f173990554?w=100&q=80"
                                 alt="Story" class="w-12 h-12 object-cover shrink-0">
                            <span style="font-size: 0.8rem; font-weight: 700; color: #110A08; letter-spacing: 0.01em;">Notre Histoire</span>
                        </button>

                        {{-- Contact --}}
                        <a href="https://wa.me/21655778665"
                           target="_blank" rel="noopener noreferrer"
                           class="flex items-center gap-3 rounded-lg overflow-hidden active:scale-95 transition-all duration-150"
                           style="background: #ffffff; border: 1px solid rgba(163,184,201,0.2); box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
                            <div class="w-12 h-12 shrink-0 flex items-center justify-center"
                                 style="background: rgba(37,211,102,0.12);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                     viewBox="0 0 24 24" fill="#25D366">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.123 1.035 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.435 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                            </div>
                            <span style="font-size: 0.8rem; font-weight: 700; color: #110A08; letter-spacing: 0.01em;">Contact</span>
                        </a>

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
                        Notre Histoire
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

                <a href="{{ url('/menu') }}"
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

                <button onclick="document.getElementById('story-section').scrollIntoView({behavior:'smooth'})"
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

            // --- 3. Intro Animation ---
            setTimeout(() => $('#intro-1').addClass('fade-up'), 500);
            setTimeout(() => $('#intro-2').addClass('fade-up'), 1500);
            setTimeout(() => $('#intro-3').addClass('fade-up'), 2500);
            setTimeout(() => $('#intro-action').addClass('fade-up'), 3500);

            $('#enter-btn').on('click', function() {
                $overlay.addClass('fade-out');
                setTimeout(() => {
                    $mainElements.css('opacity', 1);
                }, 800);
            });

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
    </script>
@endpush
