<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Söya. | prod. bistronippon 北と北</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div class="concrete-bg"></div>

    @include('parts.intro')

    <nav class="lang-switcher">
        <button class="lang-btn" data-lang="fr">FR</button>
        <button class="lang-btn active" data-lang="en">EN</button>
        <button class="lang-btn" data-lang="jp">JP</button>
    </nav>

    <div class="main-container">
        <div class="content-wrapper">
            <div class="architectural-line d-none d-md-block"></div>

            <div class="row align-items-center">
                <div class="col-lg-5 mb-5 mb-lg-0 text-center text-lg-start">
                    <p class="collab-text">prod. <span style="font-size:0.8em; margin:0 5px;">×</span>
                        Bistronippon</p>
                    <h1 class="brand-title">Söya<span class="dot-highlight">.</span></h1>

                    <h2 class="brand-subtitle" id="subtitle">
                        North and North<br>
                        <span style="font-weight: 300; opacity: 0.7; margin-right: 6px;">×</span>Tokyo Current
                    </h2>
                </div>

                <div class="col-lg-7">
                    <div class="story-text" id="story-content"></div>
                </div>
            </div>
        </div>
    </div>

    @include('parts.footer')

    <script type="module">
        $(function() {
            // --- 1. Intro Animation ---
            const $intro1 = $('#intro-1');
            const $intro2 = $('#intro-2');
            const $intro3 = $('#intro-3');
            const $action = $('#intro-action');
            const $overlay = $('#intro-overlay');
            const $enterBtn = $('#enter-btn');
            // アニメーション対象から teaser-section を削除
            const $mainElements = $('.main-container, .lang-switcher, .site-footer');

            setTimeout(() => $intro1.addClass('fade-up'), 500);
            setTimeout(() => $intro2.addClass('fade-up'), 1500);
            setTimeout(() => $intro3.addClass('fade-up'), 2500);
            setTimeout(() => $action.addClass('fade-up'), 3500);

            $enterBtn.on('click', function() {
                $overlay.addClass('fade-out');
                setTimeout(() => {
                    $mainElements.css('opacity', 1);
                }, 800);
            });

            // --- 2. Content Data ---
            const contentData = {
                'en': {
                    subtitle: `North and North<br><span style="font-weight:300; opacity:0.7; margin-right:6px;">×</span>Tokyo Current`,
                    body: `
                        <p><strong>"Söya." bears a double essence.</strong></p>
                        <p>Firstly, it pays homage to <strong>Cape Soya</strong>, the northernmost point of Japan. Like Tunisia, the northern tip of Africa, we bridge these two ends of the world.</p>
                        <p>Secondly, it signifies <strong>Soya</strong> (Soybean), the soul of Japanese cuisine and the source of Umami.</p>
                        <p>The final period <strong>"."</strong> symbolizes the destination. Just savor the essence.</p>
                        <hr style="border:0; border-top:1px solid rgba(0,0,0,0.1); margin: 30px 0;">
                        <p style="font-size: 0.9em; opacity: 0.8;">
                            Bistro Nippon marks its 10th year. Returning to Japan annually, I feel the shifting trends.
                            Söya reconstructs this <strong>"Tokyo Current"</strong> with a unique interpretation.
                        </p>
                        <p style="margin-top:20px; font-weight:600; font-size: 0.9em; letter-spacing: 0.1em;">
                            Opening this Spring in Menzah 9.
                        </p>
                    `,
                    footer: "Follow us on Instagram"
                },
                'fr': {
                    subtitle: `Nord et Nord<br><span style="font-weight:300; opacity:0.7; margin-right:6px;">×</span>Tokyo Actuel`,
                    body: `
                        <p><strong>"Söya." porte une double essence.</strong></p>
                        <p>Premièrement, un hommage au <strong>Cap Soya</strong>, l'extrême nord du Japon. Comme la Tunisie, nous relions deux extrémités du monde.</p>
                        <p>Deuxièmement, le <strong>Soya</strong> (Soja), l'âme de la cuisine japonaise et la source de l'Umami.</p>
                        <p>Le point final <strong>"."</strong> est la destination. Savourez simplement l'essentiel.</p>
                        <hr style="border:0; border-top:1px solid rgba(0,0,0,0.1); margin: 30px 0;">
                        <p style="font-size: 0.9em; opacity: 0.8;">
                            Bistro Nippon fête ses 10 ans. En retournant au Japon chaque année, je ressens l'évolution des goûts.
                            Söya reconstruit ce <strong>"Tokyo Actuel"</strong> avec une interprétation unique.
                        </p>
                        <p style="margin-top:20px; font-weight:600; font-size: 0.9em; letter-spacing: 0.1em;">
                            Ouverture ce printemps à Menzah 9.
                        </p>
                    `,
                    footer: "Suivez-nous sur Instagram"
                },
                'jp': {
                    subtitle: `北と北<br><span style="font-weight:300; opacity:0.7; margin-right:6px;">×</span>Tokyo Current`,
                    body: `
                        <p><strong>「Söya.」が宿す、二つの本質。</strong></p>
                        <p>一つは、日本の最北端<strong>「宗谷岬」</strong>へのオマージュ。アフリカの最北端・チュニジアと同じく、世界の「北と北」を結びます。</p>
                        <p>もう一つは、日本食の魂であり、旨味の源である<strong>「大豆（Soya）」</strong>。</p>
                        <p>名前の最後にあるピリオド<strong>「.」</strong>は目的地。ここで、味と空間を楽しんでください。</p>
                        <hr style="border:0; border-top:1px solid rgba(0,0,0,0.1); margin: 30px 0;">
                        <p style="font-size: 0.9em; opacity: 0.8;">
                            来年で10周年を迎える Bistro Nippon。<br>
                            毎年帰国するたびに感じる、めまぐるしい東京の食の進化/流行。<br>
                            Söya は、そんな「今の東京」を反映させた手打ちラーメンレストランです。
                        </p>
                        <p style="margin-top:20px; font-weight:600; font-size: 0.9em; letter-spacing: 0.1em;">
                            この春、Menzah 9 にて。
                        </p>
                    `,
                    footer: "Instagramをフォローする"
                }
            };

            const $story = $('#story-content');
            const $subtitle = $('#subtitle');
            const $footerText = $('#footer-text');

            // --- 3. Language Auto Detection ---
            const browserLang = navigator.language || navigator.userLanguage;
            const langCode = browserLang.substring(0, 2).toLowerCase();

            let initLang = 'en';
            if (langCode === 'ja') initLang = 'jp';
            else if (langCode === 'fr') initLang = 'fr';

            // Set Initial Content
            $subtitle.html(contentData[initLang].subtitle);
            $story.html(contentData[initLang].body).css('opacity', 1);
            $footerText.text(contentData[initLang].footer);

            $('.lang-btn').removeClass('active');
            $(`.lang-btn[data-lang="${initLang}"]`).addClass('active');

            // --- 4. Language Switch Event ---
            $('.lang-btn').on('click', function() {
                const lang = $(this).data('lang');
                $('.lang-btn').removeClass('active');
                $(this).addClass('active');

                // Fade Out
                $story.css('opacity', 0);
                $subtitle.css('opacity', 0);
                $('.site-footer').css('opacity', 0);

                setTimeout(function() {
                    // Change Text
                    $subtitle.html(contentData[lang].subtitle);
                    $story.html(contentData[lang].body);
                    $footerText.text(contentData[lang].footer);

                    // Fade In
                    $subtitle.css('opacity', 1);
                    $story.css('opacity', 1);
                    $('.site-footer').css('opacity', 1);
                }, 400);
            });
        });
    </script>
</body>

</html>
