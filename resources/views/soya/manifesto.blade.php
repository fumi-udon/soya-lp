<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SÖYA. — Flyer A5</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,500&display=swap" rel="stylesheet">

    <style>
        :root {
            --ecru:          #F4F1EB;
            --ink:           #2D2B2A; 
            --ink-soft:      #555352;
            --red:           #D32F2F;
            
            --serif:         'Playfair Display', serif;
            --sans:          'Montserrat', sans-serif;
            
            --rule:          1.5px solid var(--ink);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: #D8D5CF;
            font-family: var(--sans);
            color: var(--ink);
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1.5rem 1rem 2rem;
        }

        .print-bar {
            width: 148mm;
            display: flex;
            justify-content: flex-end;
            margin-bottom: 0.5rem;
        }
        .print-btn {
            background: var(--ink);
            color: var(--ecru);
            border: none;
            padding: 8px 18px;
            font-family: var(--sans);
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        /* ==============================
           A5 縦 148mm × 210mm
        ============================== */
        .flyer {
            width: 148mm;
            height: 210mm;
            background: var(--ecru);
            display: flex;
            flex-direction: column;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            padding: 9mm 9mm 8mm 9mm; 
            overflow: hidden;
        }

        /* ==============================
           1. HERO AREA (AURALEE Style Minimal Impact)
        ============================== */
        .hero {
            text-align: left;
            margin-bottom: 5mm;
            padding: 2mm 0 5mm;
            border-bottom: var(--rule);
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            gap: 2.5mm;
        }
        
        .hero__badge {
            color: var(--ink-soft);
            font-family: var(--sans);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.25em;
            text-transform: uppercase;
        }
        
        .hero__badge span {
            color: var(--red);
            font-weight: 700;
        }
        
        .hero__brand {
            font-family: var(--serif);
            font-size: 68px; /* A5幅に完璧に収まり、美しく制圧するサイズ */
            font-weight: 500;
            line-height: 0.85;
            letter-spacing: -0.02em;
            color: var(--ink);
            margin-left: -3px;
        }
        
        .hero__subtitle {
            font-family: var(--serif);
            font-style: italic;
            font-size: 13.5px;
            font-weight: 500;
            letter-spacing: 0.04em;
            color: var(--ink-soft);
            line-height: 1.3;
            margin-top: 0.5mm;
        }

        /* ==============================
           2. VISUAL GALLERY (写真3枚カラー)
        ============================== */
        .gallery {
            display: flex;
            flex-direction: column;
            gap: 2mm;
            margin-bottom: 5mm;
            flex-shrink: 0;
        }
        .gallery__main {
            width: 100%;
            height: 40mm;
            background: #ccc;
        }
        .gallery__split {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2mm;
        }
        .gallery__sub {
            height: 36mm;
            background: #ccc;
        }
        .gallery img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* ==============================
           3. CONCEPT TEXT (Pure French Manifesto)
        ============================== */
        .concept {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            border-top: var(--rule);
            padding-top: 1mm;
            gap: 2.5mm;
        }
        
        .concept__statement {
            font-family: var(--sans);
            font-style: italic;
            font-size: 16.5px;
            font-weight: 600;
            line-height: 1.35;
            letter-spacing: 0.01em;
            color: var(--ink);
        }
        
        .concept__description {
            font-family: var(--sans);
            font-size: 10.5px;
            font-weight: 500;
            line-height: 1.5;
            letter-spacing: 0.01em;
            color: var(--ink-soft);
            padding-left: 3mm;
            border-left: 2px solid var(--red);
        }
        
        .concept__description strong {
            color: var(--ink);
            font-weight: 700;
        }

        /* ==============================
           4. FOOTER (店舗情報 & QR)
        ============================== */
        .footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            border-top: var(--rule);
            padding-top: 4mm;
            flex-shrink: 0;
        }
        
        .footer__info {
            display: flex;
            flex-direction: column;
            gap: 1.5mm;
        }
        .footer__prod {
            font-family: var(--sans);
            font-size: 9px;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--ink-soft);
        }
        .footer__tel {
            font-family: var(--sans);
            font-size: 14px;
            font-weight: 700;
            line-height: 1.2;
            letter-spacing: 0.03em;
            color: var(--ink);
            font-variant-numeric: tabular-nums;
        }
        .footer__address {
            font-family: var(--sans);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.02em;
            line-height: 1.4;
            color: var(--ink);
            max-width: 85mm;
        }

        .footer__qr-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.5mm;
        }
        .footer__qr-text {
            font-family: var(--sans);
            font-size: 7.5px;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--red);
        }
        .footer__qr {
            width: 21mm;
            height: 21mm;
            border: 1px solid var(--ink);
            padding: 1mm;
            background: #FFFFFF;
            line-height: 0;
        }
        .footer__qr img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        @media print {
            @page { size: A5 portrait; margin: 0; }
            body { background: transparent; padding: 0; margin: 0; display: block; }
            .print-bar { display: none !important; }
            .flyer { box-shadow: none; }
        }
    </style>
</head>
<body>

    <div class="print-bar">
        <button class="print-btn" onclick="window.print()">Imprimer A5</button>
    </div>

    <div class="flyer">

        <div class="hero">
            <div class="hero__badge"><span>Nouvelle Ouverture 2026.06</span></div>
            <div class="hero__brand">SÖYA.</div>
            <div class="hero__subtitle">El Menzah 9</div>
        </div>

        <div class="gallery">
            <div class="gallery__main">
                <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?q=80&w=1000&auto=format&fit=crop" alt="Intérieur SÖYA">
            </div>
            <div class="gallery__split">
                <div class="gallery__sub">
                    <img src="https://images.unsplash.com/photo-1569050467447-ce54b3bbc37d?q=80&w=600&auto=format&fit=crop" alt="Craft Ramen">
                </div>
                <div class="gallery__sub">
                    <img src="https://images.unsplash.com/photo-1541696432-82c6da8ce7bf?q=80&w=600&auto=format&fit=crop" alt="Hand-Made Gyoza">
                </div>
            </div>
        </div>

        <div class="concept">
            <div class="concept__statement">
            Japanese Craft Ramen & Gyoza
            </div>
            <div class="concept__description">
                <strong>SÖYA.</strong> redéfinit l'expérience Tokyoïte. Un espace épuré, guidé par la précision absolue du geste et la perfection de la texture.
            </div>
        </div>

        <div class="footer">
            <div class="footer__info">
                <div class="footer__prod">Produced by Bistro Nippon</div>
                <div class="footer__tel">TEL: 54 497 077</div>
                <div class="footer__address">38 Av. Salah Ben Youssef, El Menzah 9</div>
            </div>
            <div class="footer__qr-wrap">
                <div class="footer__qr-text">Scan To Discover</div>
                <div class="footer__qr">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=https://wa.me/21654497077&color=2D2B2A&bgcolor=F4F1EB" alt="QR Code SÖYA">
                </div>
            </div>
        </div>

    </div>

</body>
</html>