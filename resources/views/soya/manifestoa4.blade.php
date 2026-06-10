<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SÖYA. — The Craft</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Urbanist:wght@300;400;500;600;700&family=Noto+Serif+JP:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        :root {
            --ecru:     #EDEBE5;
            --ink:      #181816;
            --ink-mid:  #3A3A38;
            --ink-soft: #6A6866;
            --rule:     rgba(24, 24, 22, 0.12);
            --serif:    'Playfair Display', Georgia, serif;
            --sans:     'Urbanist', sans-serif;
            --jp:       'Noto Serif JP', serif;
            --frame-h:  34mm;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: #C8C5BF;
            font-family: var(--sans);
            color: var(--ink);
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem 1rem 3rem;
        }

        .print-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--ink);
            color: var(--ecru);
            border: none;
            padding: 10px 22px;
            font-family: var(--sans);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.22em;
            cursor: pointer;
            transition: opacity 0.2s;
            text-transform: uppercase;
            margin-bottom: 20px;
        }
        .print-btn:hover { opacity: 0.78; }

        /* A4横 297mm × 210mm */
        .page {
            width: 297mm;
            height: 210mm;
            max-width: 100%;
            background: var(--ecru);
            position: relative;
            overflow: hidden;
            display: grid;
            grid-template-columns: 32mm 1fr;
            grid-template-rows: 1fr;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.14);
        }

        /* 左帯：ブランド */
        .band {
            background: var(--ink);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            padding: 12mm 0;
            z-index: 10;
        }

        .band__brand {
            writing-mode: vertical-rl;
            transform: rotate(180deg);
            font-family: var(--serif);
            font-size: 26px;
            font-weight: 500;
            letter-spacing: 0.14em;
            color: var(--ecru);
        }

        .band__sub {
            writing-mode: vertical-rl;
            transform: rotate(180deg);
            font-family: var(--sans);
            font-size: 8.5px;
            font-weight: 700;
            letter-spacing: 0.25em;
            color: rgba(237, 235, 229, 0.55);
            text-transform: uppercase;
            white-space: nowrap;
        }

        /* メインコンテンツ */
        .main {
            display: flex;
            flex-direction: column;
            height: 100%;
            padding: 10mm 12mm;
            min-height: 0;
        }

        .manifesto-top {
            flex-shrink: 0;
            margin-bottom: 7mm;
            border-bottom: 1.5px solid var(--ink);
            padding-bottom: 7mm;
        }

        .manifesto-top h1 {
            font-family: var(--serif);
            font-size: 36px;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            line-height: 1.15;
            margin-bottom: 3mm;
        }

        .manifesto-top p {
            font-family: var(--sans);
            font-size: 15.5px;
            font-weight: 500;
            line-height: 1.6;
            color: var(--ink-mid);
            max-width: 850px;
        }

        /* カラム：シンメトリー・ボトム揃え */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1px 1fr;
            gap: 10mm;
            flex: 1;
            min-height: 0;
            align-items: stretch;
        }

        .col {
            display: flex;
            flex-direction: column;
            background: var(--ecru);
            min-height: 100%;
        }

        .col__copy {
            flex: 1 1 auto;
            display: flex;
            flex-direction: column;
            min-height: 0;
        }

        .col__eyebrow {
            font-family: var(--sans);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.2em;
            color: var(--ink-soft);
            text-transform: uppercase;
            margin-bottom: 3mm;
        }

        .col__title {
            font-family: var(--serif);
            font-size: 38px;
            font-weight: 600;
            line-height: 1.1;
            margin-bottom: 2mm;
            color: var(--ink);
        }

        .col__jp {
            font-family: var(--jp);
            font-size: 13px;
            font-weight: 500;
            letter-spacing: 0.15em;
            color: var(--ink-soft);
            margin-bottom: 5mm;
        }

        .col__body {
            font-family: var(--sans);
            font-size: 15.5px;
            font-weight: 500;
            line-height: 1.65;
            color: var(--ink-mid);
        }

        .col__body strong {
            font-weight: 700;
            color: var(--ink);
        }

        /* カタログ風・独立写真フレーム */
        .col__frame {
            flex-shrink: 0;
            width: 100%;
            height: var(--frame-h);
            margin-top: 5mm;
            border: 1px solid var(--rule);
            background: var(--ecru);
            overflow: hidden;
            line-height: 0;
        }

        .col__frame img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            /* モノクロ印刷：中間調を保ち黒潰れを防ぐ */
            filter: grayscale(100%) contrast(0.92) brightness(1.08);
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .col--gyoza .col__frame img {
            object-position: center 75%;
            filter: grayscale(100%) contrast(0.88) brightness(1.12);
        }

        .vline {
            background: var(--rule);
        }

        @media print {
            @page { size: A4 landscape; margin: 0; }
            body { background: transparent; padding: 0; margin: 0; }
            .print-btn { display: none !important; }
            .page {
                box-shadow: none;
                width: 297mm;
                height: 210mm;
            }
            .col__frame img {
                filter: grayscale(100%) contrast(0.92) brightness(1.08);
            }
            .col--gyoza .col__frame img {
                filter: grayscale(100%) contrast(0.88) brightness(1.12);
            }
        }
    </style>
</head>
<body>

    <button class="print-btn" onclick="window.print()">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="6 9 6 2 18 2 18 9"/>
            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
            <rect x="6" y="14" width="12" height="8"/>
        </svg>
        Print A4 Landscape
    </button>

    <div class="page">
        <div class="band">
            <div class="band__brand">SÖYA.</div>
            <div class="band__sub">Produced by Bistro Nippon</div>
        </div>

        <main class="main">
            <section class="manifesto-top">
                <h1>THE CRAFT : Tokyo Current</h1>
                <p>
                    Dix ans d'expertise artisanale à La Marsa, subtilement mis à jour. Notre quête absolue du ramen s'accompagne désormais de nos gyoza faits maison. Une seule et même maîtrise technique, dédiée à la perfection de la texture.
                </p>
            </section>

            <div class="content-grid">
                <article class="col col--ramen">
                    <div class="col__copy">
                        <span class="col__eyebrow">Artisanal Noodle Craft</span>
                        <h2 class="col__title">L'Art du Ramen</h2>
                        <span class="col__jp">自家製手打ち麺</span>
                        <div class="col__body">
                            Forts de dix ans d'expérience dans la fabrication de nouilles à La Marsa, chaque processus est rigoureusement supervisé par notre chef japonais.<br><br>
                            Chaque jour, la pâte est pétrie à la main et ajustée selon l'humidité du moment. Une texture vivante, créée pour capturer l'essence de notre bouillon.<br><br>
                            <strong>Goûtez-les seules d'abord</strong> pour en apprécier le parfum pur du blé — la signature d'un savoir-faire authentique.
                        </div>
                    </div>
                    <figure class="col__frame">
                        <img src="{{ asset('images/craft_ramen.jpg') }}"
                             alt="Fabrication artisanale des nouilles SÖYA."
                             width="1080" height="720" loading="eager" decoding="async">
                    </figure>
                </article>

                <div class="vline" aria-hidden="true"></div>

                <article class="col col--gyoza">
                    <div class="col__copy">
                        <span class="col__eyebrow">Hand-Made Craft</span>
                        <h2 class="col__title">L'Art du Gyoza</h2>
                        <span class="col__jp">手包みモチモチ餃子</span>
                        <div class="col__body">
                            Plier un gyoza à la main prend du temps. C'est précisément pour cela que nous le faisons.<br><br>
                            Chaque pièce, façonnée une à une. La pâte fraîche, préparée sur place, est ensuite <strong>maturée par le froid</strong> pour en sublimer la texture.<br><br>
                            Ce moelleux profond qu'on appelle en japonais « <strong>mochi-mochi</strong> » — la machine ne peut pas l'imiter.
                        </div>
                    </div>
                    <figure class="col__frame">
                        <img src="{{ asset('images/gyoza_bg.jpg') }}"
                             alt="Gyoza faits main SÖYA."
                             width="1196" height="787" loading="eager" decoding="async">
                    </figure>
                </article>
            </div>
        </main>
    </div>

</body>
</html>
