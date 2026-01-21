<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Söya. | New Project in Menzah 9</title>
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
                    <p class="collab-text">Söya. <span style="font-size:0.8em; margin:0 5px;">×</span> bistronippon</p>
                    <h1 class="brand-title">Söya<span class="dot-highlight">.</span></h1>
                    <h2 class="brand-subtitle" id="subtitle">The Extreme North x The Essence of Taste</h2>
                </div>
                <div class="col-lg-7">
                    <div class="story-text" id="story-content"></div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer-insta">
        <a href="https://www.instagram.com/bistronippon/" target="_blank">
            Follow progress on Instagram
        </a>
    </footer>

    <script type="module">
        $(function() {
            // --- Intro Logic (Manual Dismiss) ---
            const $intro1 = $('#intro-1');
            const $intro2 = $('#intro-2');
            const $intro3 = $('#intro-3');
            const $action = $('#intro-action');
            const $overlay = $('#intro-overlay');
            const $enterBtn = $('#enter-btn');

            // フェードイン対象の要素
            const $mainElements = $('.main-container, .lang-switcher, .footer-insta');

            // 1. テキストを順番に表示
            setTimeout(() => $intro1.addClass('fade-up'), 500);
            setTimeout(() => $intro2.addClass('fade-up'), 1500);
            setTimeout(() => $intro3.addClass('fade-up'), 2500);

            // 2. 最後にボタンを表示
            setTimeout(() => $action.addClass('fade-up'), 3500);

            // 3. ボタンクリック処理
            $enterBtn.on('click', function() {
                // イントロをフェードアウト
                $overlay.addClass('fade-out');

                // メインコンテンツを表示
                setTimeout(() => {
                    $mainElements.css('opacity', 1);
                }, 800);
            });

            // --- Language Logic ---
            const contentData = {
                'fr': {
                    subtitle: "L'Extrême Nord x L'Essence du Goût",
                    body: `<p><strong>"Söya." porte une double essence.</strong></p><p>D'une part, c'est l'hommage au <strong>Cap Soya</strong>, le point le plus au nord du Japon. Comme la Tunisie, pointe septentrionale de l'Afrique, nous relions ces deux extrémités du monde.</p><p>D'autre part, c'est le <strong>Soya</strong> (Soja), l'âme de la cuisine japonaise et la source de l'Umami.</p><p>Le point final <strong>"."</strong> symbolise notre destination.<br>Ici, au carrefour du Nord et du Goût, votre voyage s'arrête pour savourer l'essentiel.</p>`
                },
                'en': {
                    subtitle: "The Extreme North x The Essence of Taste",
                    body: `<p><strong>"Söya." bears a double essence.</strong></p><p>Firstly, it pays homage to <strong>Cape Soya</strong>, the northernmost point of Japan. Like Tunisia, the northern tip of Africa, we bridge these two ends of the world.</p><p>Secondly, it signifies <strong>Soya</strong> (Soybean), the soul of Japanese cuisine and the source of Umami.</p><p>The final period <strong>"."</strong> symbolizes our destination.<br>Here, at the crossroads of the North and Taste, your journey pauses to savor the essential.</p>`
                },
                'jp': {
                    subtitle: "北の最果て × 味の真髄",
                    body: `<p><strong>「Söya.」には、2つの本質があります。</strong></p><p>一つは、日本の最北端<strong>「宗谷岬」</strong>へのオマージュ。アフリカの最北端であるチュニジアと同じく、世界の「北の果て」同士を結ぶ架け橋です。</p><p>もう一つは、日本食の魂であり、旨味の源である<strong>「大豆（Soya）」</strong>。</p><p>そして最後の<strong>ピリオド「.」</strong>は、旅の目的地を意味します。<br>北と北、そして味の交差点であるこの場所で、本質を味わう旅は完結します。</p>`
                }
            };
            const $story = $('#story-content');
            const $subtitle = $('#subtitle');

            // 初期表示: English
            $story.html(contentData['en'].body).css('opacity', 1);

            $('.lang-btn').on('click', function() {
                const lang = $(this).data('lang');
                $('.lang-btn').removeClass('active');
                $(this).addClass('active');

                $story.css('opacity', 0);
                $subtitle.css('opacity', 0);

                setTimeout(function() {
                    $subtitle.text(contentData[lang].subtitle);
                    $story.html(contentData[lang].body);
                    $subtitle.css('opacity', 1);
                    $story.css('opacity', 1);
                }, 400);
            });
        });
    </script>
</body>

</html>
