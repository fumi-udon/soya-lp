<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#1a1208">
    <meta name="description" content="Söya — Japanese Ramen menu, La Marsa, Tunisia">
    <title>Söya | Menu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=DM+Sans:wght@300;400;500&display=swap"
        rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            -webkit-text-size-adjust: 100%;
            scroll-behavior: smooth;
        }

        body {
            font-family: 'DM Sans', system-ui, -apple-system, sans-serif;
            background: #0f0b06;
            color: #f5ead8;
            min-height: 100dvh;
            line-height: 1.5;
        }

        .menu-wrap {
            width: 100%;
            max-width: 680px;
            margin: 0 auto;
            min-height: 100dvh;
            background: #1a1208;
            position: relative;
            overflow-x: hidden;
        }

        .texture {
            position: absolute;
            inset: 0;
            background-image: repeating-linear-gradient(0deg,
                    transparent,
                    transparent 2px,
                    rgba(255, 255, 255, 0.015) 2px,
                    rgba(255, 255, 255, 0.015) 4px);
            pointer-events: none;
            z-index: 0;
        }

        .content {
            position: relative;
            z-index: 1;
            padding: max(1.25rem, env(safe-area-inset-top)) max(1rem, env(safe-area-inset-right)) max(1.5rem, env(safe-area-inset-bottom)) max(1rem, env(safe-area-inset-left));
        }

        @media (min-width: 400px) {
            .content {
                padding: max(1.75rem, env(safe-area-inset-top)) 1.5rem max(2rem, env(safe-area-inset-bottom)) 1.5rem;
            }
        }

        @media (min-width: 480px) {
            .content {
                padding: 2.5rem 2rem 2.5rem;
            }
        }

        .header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1.25rem;
            border-bottom: 1px solid rgba(212, 174, 98, 0.3);
        }

        .header-top {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            margin-bottom: 0.5rem;
        }

        .logo-mark {
            flex-shrink: 0;
            width: 44px;
            height: 44px;
            border: 1.5px solid #d4ae62;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Playfair Display', serif;
            font-size: 1.125rem;
            color: #d4ae62;
        }

        .brand {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.75rem, 6vw, 2.4rem);
            color: #d4ae62;
            letter-spacing: 0.05em;
        }

        .tagline {
            font-size: 0.625rem;
            letter-spacing: 0.2em;
            color: rgba(245, 234, 216, 0.5);
            text-transform: uppercase;
            margin-top: 0.25rem;
            padding: 0 0.5rem;
            line-height: 1.6;
        }

        .section {
            margin-bottom: 1.75rem;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .section-icon {
            font-size: 1rem;
            line-height: 1;
            flex-shrink: 0;
        }

        .section-title {
            font-size: 0.625rem;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: #d4ae62;
            font-weight: 500;
            white-space: nowrap;
        }

        .section-line {
            flex: 1;
            min-width: 1rem;
            height: 1px;
            background: rgba(212, 174, 98, 0.2);
        }

        .item {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: flex-start;
            gap: 0.35rem 0.75rem;
            margin-bottom: 1.125rem;
            padding-bottom: 0.125rem;
        }

        .item-body {
            flex: 1 1 12rem;
            min-width: 0;
        }

        .item-name {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1rem, 3.5vw, 1.05rem);
            color: #f5ead8;
            font-weight: 400;
            line-height: 1.35;
        }

        .item-meta {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.35rem 0.5rem;
            margin-top: 0.2rem;
        }

        .item-variant {
            font-size: 0.6875rem;
            color: rgba(245, 234, 216, 0.45);
            font-weight: 300;
        }

        .badge {
            display: inline-block;
            font-size: 0.5625rem;
            padding: 0.15rem 0.45rem;
            border-radius: 20px;
            letter-spacing: 0.08em;
            font-weight: 500;
            text-transform: uppercase;
            line-height: 1.4;
        }

        .badge-vegan {
            background: rgba(99, 153, 34, 0.2);
            color: #97c459;
            border: 0.5px solid rgba(97, 196, 89, 0.3);
        }

        .badge-gf {
            background: rgba(186, 117, 23, 0.2);
            color: #fac775;
            border: 0.5px solid rgba(239, 159, 39, 0.3);
        }

        .badge-spicy {
            background: rgba(216, 90, 48, 0.2);
            color: #f09575;
            border: 0.5px solid rgba(216, 90, 48, 0.3);
        }

        .badge-new {
            background: rgba(83, 74, 183, 0.25);
            color: #afa9ec;
            border: 0.5px solid rgba(127, 119, 221, 0.35);
        }

        .item-desc {
            font-size: 0.71875rem;
            color: rgba(245, 234, 216, 0.5);
            line-height: 1.65;
            margin-top: 0.35rem;
            font-weight: 300;
            font-style: italic;
        }

        .item-price {
            flex-shrink: 0;
            font-family: 'Playfair Display', serif;
            font-size: 1rem;
            color: #d4ae62;
            white-space: nowrap;
            text-align: right;
            padding-top: 0.125rem;
        }

        .item-price span {
            font-size: 0.625rem;
            color: rgba(212, 174, 98, 0.6);
            margin-left: 0.125rem;
        }

        .divider {
            height: 1px;
            background: rgba(245, 234, 216, 0.07);
            margin: 0.5rem 0 1.25rem;
            border: none;
        }

        .img-placeholder {
            width: 100%;
            aspect-ratio: 16 / 7;
            max-height: 160px;
            border-radius: 8px;
            margin-bottom: 1.25rem;
            border: 0.5px solid rgba(212, 174, 98, 0.15);
            background: linear-gradient(135deg, #2a1e0e, #1a1208);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 0.35rem;
        }

        .img-placeholder .ph-icon {
            font-size: 1.75rem;
            line-height: 1;
            opacity: 0.35;
        }

        .img-placeholder span {
            font-size: 0.625rem;
            letter-spacing: 0.12em;
            color: rgba(212, 174, 98, 0.35);
            text-transform: uppercase;
        }

        .two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.625rem;
            margin-bottom: 1.25rem;
        }

        @media (max-width: 320px) {
            .two-col {
                grid-template-columns: 1fr;
            }
        }

        .img-sm {
            aspect-ratio: 4 / 3;
            min-height: 72px;
            border-radius: 8px;
            border: 0.5px solid rgba(212, 174, 98, 0.15);
            background: linear-gradient(135deg, #2a1e0e, #1a1208);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 0.25rem;
            padding: 0.5rem;
        }

        .img-sm .ph-icon {
            font-size: 1.25rem;
            line-height: 1;
            opacity: 0.3;
        }

        .img-sm span {
            font-size: 0.5625rem;
            letter-spacing: 0.08em;
            color: rgba(212, 174, 98, 0.35);
            text-transform: uppercase;
            text-align: center;
        }

        .footer {
            text-align: center;
            padding-top: 1.25rem;
            border-top: 1px solid rgba(212, 174, 98, 0.2);
            margin-top: 0.5rem;
        }

        .footer p {
            font-size: 0.625rem;
            letter-spacing: 0.18em;
            color: rgba(245, 234, 216, 0.3);
            text-transform: uppercase;
        }

        .footer .jp {
            font-size: 0.875rem;
            color: rgba(212, 174, 98, 0.4);
            margin-bottom: 0.35rem;
            letter-spacing: 0.3em;
        }

        .subsection-label {
            font-size: 0.625rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: rgba(212, 174, 98, 0.45);
            margin: 0.75rem 0 0.75rem;
        }
    </style>
</head>

<body>
    <div class="menu-wrap">
        <div class="texture" aria-hidden="true"></div>
        <main class="content">

            <header class="header">
                <div class="header-top">
                    <div class="logo-mark" aria-hidden="true">S</div>
                    <h1 class="brand">Söya</h1>
                </div>
                <p class="tagline">Japanese Ramen · La Marsa · Tunisia</p>
            </header>

            <div class="img-placeholder" role="img" aria-label="Ramen bowl hero photo placeholder">
                <span class="ph-icon" aria-hidden="true">🍜</span>
                <span>Hero photo — ramen bowl</span>
            </div>

            <section class="section" aria-labelledby="section-broth">
                <div class="section-header">
                    <span class="section-icon" aria-hidden="true">🍜</span>
                    <h2 id="section-broth" class="section-title">Noodles in Broth</h2>
                    <div class="section-line" aria-hidden="true"></div>
                </div>

                <div class="two-col" aria-hidden="true">
                    <div class="img-sm">
                        <span class="ph-icon">💧</span>
                        <span>Miso ramen</span>
                    </div>
                    <div class="img-sm">
                        <span class="ph-icon">🔥</span>
                        <span>Malâ red</span>
                    </div>
                </div>

                <article class="item">
                    <div class="item-body">
                        <h3 class="item-name">Söya Miso Ramen</h3>
                        <div class="item-meta">
                            <span class="item-variant">Chashu / Fruits de mer</span>
                        </div>
                        <p class="item-desc">Bouillon miso maison, riche et savoureux, garni au choix de chashu ou fruits de mer.</p>
                    </div>
                    <div class="item-price" aria-label="32 TND">32<span>TND</span></div>
                </article>

                <article class="item">
                    <div class="item-body">
                        <h3 class="item-name">Malâ Red Ramen</h3>
                        <div class="item-meta">
                            <span class="badge badge-spicy">Épicé</span>
                            <span class="item-variant">Fruits de mer</span>
                        </div>
                        <p class="item-desc">Bouillon rouge épicé à l'huile Malâ, intense et parfumé, garni de fruits de mer.</p>
                    </div>
                    <div class="item-price" aria-label="32 TND">32<span>TND</span></div>
                </article>
            </section>

            <hr class="divider">

            <section class="section" aria-labelledby="section-sauce">
                <div class="section-header">
                    <span class="section-icon" aria-hidden="true">🥢</span>
                    <h2 id="section-sauce" class="section-title">Noodles bathed in Sauce</h2>
                    <div class="section-line" aria-hidden="true"></div>
                </div>

                <article class="item">
                    <div class="item-body">
                        <h3 class="item-name">Söya Mix Ramen</h3>
                        <div class="item-meta">
                            <span class="badge badge-new">New Style</span>
                            <span class="item-variant">Chashu / Fruits de mer</span>
                        </div>
                        <p class="item-desc">Nouilles japonaises nappées de sauce maison. Bien mélanger avant de déguster. Terminer avec du riz — demandez au staff.</p>
                    </div>
                    <div class="item-price" aria-label="28 TND">28<span>TND</span></div>
                </article>

                <article class="item">
                    <div class="item-body">
                        <h3 class="item-name">Mabo-Malâ Mix Ramen</h3>
                        <div class="item-meta">
                            <span class="badge badge-spicy">Épicé</span>
                            <span class="item-variant">Poulet · Aubergine</span>
                        </div>
                        <p class="item-desc">Nouilles mélangées à la sauce Mabo épicée Malâ, poulet tendre et aubergine fondante.</p>
                    </div>
                    <div class="item-price" aria-label="28 TND">28<span>TND</span></div>
                </article>

                <article class="item">
                    <div class="item-body">
                        <h3 class="item-name">Tan-Tan Mix Ramen</h3>
                        <div class="item-meta">
                            <span class="badge badge-spicy">Épicé</span>
                        </div>
                        <p class="item-desc">Nouilles mélangées à la sauce tantanmen épicée, viande hachée et crème de sésame. Bien mélanger avant de déguster. Terminer avec du riz — demandez au staff.</p>
                    </div>
                    <div class="item-price" aria-label="28 TND">28<span>TND</span></div>
                </article>
            </section>

            <hr class="divider">

            <section class="section" aria-labelledby="section-rice">
                <div class="section-header">
                    <span class="section-icon" aria-hidden="true">🍚</span>
                    <h2 id="section-rice" class="section-title">Rice</h2>
                    <div class="section-line" aria-hidden="true"></div>
                </div>

                <article class="item">
                    <div class="item-body">
                        <h3 class="item-name">Onigiri du Jour</h3>
                        <p class="item-desc">Boulette de riz japonaise garnie du jour. Demandez au staff.</p>
                    </div>
                    <div class="item-price" aria-label="9 TND">9<span>TND</span></div>
                </article>

                <article class="item">
                    <div class="item-body">
                        <h3 class="item-name">Donburi Katsu Poulet</h3>
                        <p class="item-desc">Bol de riz garni de poulet pané, œufs liés à la sauce maison.</p>
                    </div>
                    <div class="item-price" aria-label="24 TND">24<span>TND</span></div>
                </article>

                <article class="item">
                    <div class="item-body">
                        <h3 class="item-name">Curry Rice</h3>
                        <div class="item-meta">
                            <span class="badge badge-vegan">Vegan</span>
                            <span class="badge badge-gf">Gluten Free</span>
                        </div>
                        <p class="item-desc">Curry japonais doux et parfumé, servi sur riz. 100% végétal et sans gluten.</p>
                    </div>
                    <div class="item-price" aria-label="22 TND">22<span>TND</span></div>
                </article>

                <article class="item">
                    <div class="item-body">
                        <h3 class="item-name">Donburi Mabo Chicken</h3>
                        <div class="item-meta">
                            <span class="badge badge-spicy">Épicé</span>
                        </div>
                        <p class="item-desc">Bol de riz garni de poulet tendre, aubergine et sauce Mabo épicée Malâ.</p>
                    </div>
                    <div class="item-price" aria-label="24 TND">24<span>TND</span></div>
                </article>
            </section>

            <hr class="divider">

            <section class="section" aria-labelledby="section-plates">
                <div class="section-header">
                    <span class="section-icon" aria-hidden="true">🍽️</span>
                    <h2 id="section-plates" class="section-title">Small Plates</h2>
                    <div class="section-line" aria-hidden="true"></div>
                </div>

                <article class="item">
                    <div class="item-body">
                        <h3 class="item-name">Canard Rosé</h3>
                        <p class="item-desc">Magret de canard rosé, sauce japonaise maison.</p>
                    </div>
                    <div class="item-price" aria-label="28 TND">28<span>TND</span></div>
                </article>

                <article class="item">
                    <div class="item-body">
                        <h3 class="item-name">Mabo Chicken</h3>
                        <div class="item-meta">
                            <span class="badge badge-spicy">Épicé</span>
                        </div>
                        <p class="item-desc">Poulet tendre et aubergine fondante à la sauce Mabo, idéal avec un bol de riz.</p>
                    </div>
                    <div class="item-price" aria-label="22 TND">22<span>TND</span></div>
                </article>

                <article class="item">
                    <div class="item-body">
                        <h3 class="item-name">Gyoza Chicken</h3>
                        <div class="item-meta">
                            <span class="item-variant">6 pièces</span>
                        </div>
                        <p class="item-desc">Raviolis japonais grillés au poulet, croustillants dehors, fondants dedans.</p>
                    </div>
                    <div class="item-price" aria-label="16 TND">16<span>TND</span></div>
                </article>

                <article class="item">
                    <div class="item-body">
                        <h3 class="item-name">Gyoza Veggi</h3>
                        <div class="item-meta">
                            <span class="item-variant">6 pièces</span>
                            <span class="badge badge-vegan">Vegan</span>
                        </div>
                        <p class="item-desc">Raviolis japonais grillés aux légumes, savoureux et légers.</p>
                    </div>
                    <div class="item-price" aria-label="15 TND">15<span>TND</span></div>
                </article>

                <article class="item">
                    <div class="item-body">
                        <h3 class="item-name">Sardines Nikkei Marinées</h3>
                        <p class="item-desc">Sardines marinées à la sauce japonaise, fraîches et acidulées.</p>
                    </div>
                    <div class="item-price" aria-label="14 TND">14<span>TND</span></div>
                </article>

                <article class="item">
                    <div class="item-body">
                        <h3 class="item-name">Korokke</h3>
                        <div class="item-meta">
                            <span class="item-variant">2 pièces</span>
                        </div>
                        <p class="item-desc">Croquettes japonaises, onctueuses à l'intérieur, croustillantes dehors.</p>
                    </div>
                    <div class="item-price" aria-label="13 TND">13<span>TND</span></div>
                </article>

                <article class="item">
                    <div class="item-body">
                        <h3 class="item-name">Salade Wakamé Zesté</h3>
                        <p class="item-desc">Algues wakamé fraîches, vinaigrette au zeste d'agrumes.</p>
                    </div>
                    <div class="item-price" aria-label="11 TND">11<span>TND</span></div>
                </article>

                <hr class="divider">

                <p class="subsection-label">Soups</p>

                <article class="item">
                    <div class="item-body">
                        <h3 class="item-name">Soupe Miso Wakamé</h3>
                        <p class="item-desc">Bouillon miso délicat, algues wakamé, tofu soyeux.</p>
                    </div>
                    <div class="item-price" aria-label="8 TND">8<span>TND</span></div>
                </article>

                <article class="item">
                    <div class="item-body">
                        <h3 class="item-name">Soupe Miso Fruits de Mer</h3>
                        <p class="item-desc">Bouillon miso parfumé aux fruits de mer frais.</p>
                    </div>
                    <div class="item-price" aria-label="10 TND">10<span>TND</span></div>
                </article>
            </section>

            <footer class="footer">
                <div class="jp" aria-hidden="true">そ や</div>
                <p>La Marsa · Tunisia · {{ date('Y') }}</p>
            </footer>

        </main>
    </div>
</body>

</html>
