@extends('layouts.soya')

@section('title', 'Söya. | prod. bistronippon 北と北')

@section('content')
    {{-- 1. Intro Splash --}}
    @include('parts.intro')

    {{-- 2. Main Content --}}
    <div class="main-container">
        <div class="content-wrapper">
            <div class="architectural-line d-none d-md-block"></div>

            <div class="row align-items-center">
                <div class="col-lg-5 mb-5 mb-lg-0 text-center text-lg-start">
                    <p class="collab-text animate__animated animate__fadeIn">
                        Bistronippon <span style="font-size:0.8em; margin:0 5px;">→</span> Menzah 9
                    </p>
                    <h1 class="brand-title">Söya<span class="dot-highlight">.</span></h1>

                    <h2 class="brand-subtitle" id="subtitle">
                        {{-- JSで動的に挿入 --}}
                    </h2>
                </div>

                <div class="col-lg-7">
                    <div class="story-text" id="story-content">
                        {{-- JSで動的に挿入 --}}
                    </div>
                </div>
            </div>
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
    </script>
@endpush
