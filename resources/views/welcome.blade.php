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

    <footer class="footer-insta">
        <p class="insta-text" id="footer-text">Check Instagram for updates.</p>

        <a href="https://www.instagram.com/soya.tunis/" target="_blank" class="insta-icon-link">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="20" height="20"
                style="width: 20px; height: 20px;">
                <path
                    d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.5 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.9 0-184.9zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z" />
            </svg>
        </a>
    </footer>

    <script type="module">
        $(function() {
            // --- 1. Intro Animation ---
            const $intro1 = $('#intro-1');
            const $intro2 = $('#intro-2');
            const $intro3 = $('#intro-3');
            const $action = $('#intro-action');
            const $overlay = $('#intro-overlay');
            const $enterBtn = $('#enter-btn');
            const $mainElements = $('.main-container, .lang-switcher, .footer-insta');

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
                    footer: "Check Instagram for updates."
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
                    footer: "Infos et mises à jour sur Instagram."
                },
                'jp': {
                    subtitle: `北と北<br><span style="font-weight:300; opacity:0.7; margin-right:6px;">×</span>Tokyo Current`,
                    body: `
                        <p><strong>「Söya.」が宿す、二つの本質。</strong></p>
                        <p>一つは、日本の最北端<strong>「宗谷岬」</strong>へのオマージュ。アフリカの最北端・チュニジアと同じく、世界の「北と北」を結びます。</p>
                        <p>もう一つは、日本食の魂であり、旨味の源である<strong>「大豆（Soya）」</strong>。</p>
                        <p>名前の最後にあるピリオド<strong>「.」</strong>は目的地。ここで、シンプルに味を楽しんでください。</p>
                        <hr style="border:0; border-top:1px solid rgba(0,0,0,0.1); margin: 30px 0;">
                        <p style="font-size: 0.9em; opacity: 0.8;">
                            来年で10周年を迎える Bistro Nippon。<br>
                            毎年帰国するたびに感じる、めまぐるしい東京の食の進化。<br>
                            Söya は、そんな「今の東京」を反映させたクラフト・ラーメンです。
                        </p>
                        <p style="margin-top:20px; font-weight:600; font-size: 0.9em; letter-spacing: 0.1em;">
                            この春、Menzah 9 にて。
                        </p>
                    `,
                    footer: "最新情報はInstagramでキャッチしてください。"
                }
            };

            const $story = $('#story-content');
            const $subtitle = $('#subtitle');
            const $footerText = $('#footer-text');

            // --- 3. Language Auto Detection ---
            // ブラウザの言語を取得 (例: "ja-JP", "fr-FR", "en-US")
            const browserLang = navigator.language || navigator.userLanguage;
            const langCode = browserLang.substring(0, 2).toLowerCase(); // 最初の2文字 ("ja", "fr", "en")

            let initLang = 'en'; // デフォルトは英語

            if (langCode === 'ja') {
                initLang = 'jp';
            } else if (langCode === 'fr') {
                initLang = 'fr';
            }

            // 初期表示をセット
            $subtitle.html(contentData[initLang].subtitle);
            $story.html(contentData[initLang].body).css('opacity', 1);
            $footerText.text(contentData[initLang].footer);

            // ボタンのActive状態をセット
            $('.lang-btn').removeClass('active');
            $(`.lang-btn[data-lang="${initLang}"]`).addClass('active');

            // --- 4. Language Switch Event ---
            $('.lang-btn').on('click', function() {
                const lang = $(this).data('lang');
                $('.lang-btn').removeClass('active');
                $(this).addClass('active');

                $story.css('opacity', 0);
                $subtitle.css('opacity', 0);
                $('.footer-insta').css('opacity', 0);

                setTimeout(function() {
                    $subtitle.html(contentData[lang].subtitle);
                    $story.html(contentData[lang].body);
                    $footerText.text(contentData[lang].footer);

                    $subtitle.css('opacity', 1);
                    $story.css('opacity', 1);
                    $('.footer-insta').css('opacity', 1);
                }, 400);
            });
        });
    </script>
</body>

</html>
