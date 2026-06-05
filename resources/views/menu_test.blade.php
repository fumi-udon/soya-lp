{{-- resources/views/menu/index.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<meta name="theme-color" content="#0a0a08">
<title>Söya. — Craft Ramen & Gyoza</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --ink:#0a0a08;
  --ink-soft:#3a3935;
  --ink-faint:#8a8880;
  --paper:#f7f5f0;
  --paper-warm:#efece4;
  --paper-card:#faf9f6;
  --red:#c41e1e;
  --gold:#9a7000;
  --gold-soft:#f5f0e0;
  --teal:#0f6e56;
  --teal-soft:#e4f2ee;
  --coral:#c45c2e;
  --coral-soft:#f5ede8;
  --blue:#1a5fa8;
  --blue-soft:#e6f1fb;
  --line:rgba(10,10,8,.10);
  --r:14px;
  --r-sm:8px;
  --serif:'Cormorant Garamond',Georgia,serif;
  --sans:'DM Sans',sans-serif;
}

html { background: var(--ink); }
body {
  font-family: var(--sans);
  background: var(--paper);
  color: var(--ink);
  min-height: 100dvh;
  -webkit-font-smoothing: antialiased;
  padding-bottom: env(safe-area-inset-bottom, 20px);
}

/* ── Hero ── */
.hero {
  background: var(--ink);
  padding: 52px 24px 36px;
  text-align: center;
  position: relative;
  overflow: hidden;
}
.hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background:
    radial-gradient(ellipse 60% 40% at 25% 80%, rgba(196,30,30,.20) 0%, transparent 70%),
    radial-gradient(ellipse 50% 50% at 78% 15%, rgba(154,112,0,.14) 0%, transparent 70%);
  pointer-events: none;
}
.hero-eye {
  font-size: 9px;
  font-weight: 500;
  letter-spacing: 4px;
  color: rgba(247,245,240,.35);
  text-transform: uppercase;
  margin-bottom: 14px;
}
.hero-title {
  font-family: var(--serif);
  font-size: 58px;
  font-weight: 300;
  color: #f7f5f0;
  letter-spacing: 7px;
  line-height: 1;
  margin-bottom: 6px;
}
.hero-title em { color: var(--red); font-style: normal; }
.hero-sub {
  font-family: var(--serif);
  font-size: 13px;
  font-style: italic;
  color: rgba(247,245,240,.40);
  letter-spacing: 1.5px;
}
.hero-line {
  width: 28px;
  height: .5px;
  background: rgba(247,245,240,.18);
  margin: 18px auto 0;
}

/* ── Tea banner ── */
.tea {
  background: var(--teal);
  padding: 13px 20px;
  display: flex;
  align-items: center;
  gap: 11px;
}
.tea-icon { font-size: 20px; flex-shrink: 0; }
.tea-txt { font-size: 12px; color: rgba(255,255,255,.80); line-height: 1.5; }
.tea-txt strong { color: #fff; font-weight: 500; font-size: 13px; display: block; margin-bottom: 1px; }
.tea-arabizi { font-size: 11px; color: rgba(255,255,255,.45); margin-top: 2px; }

/* ── Sections ── */
.section { padding: 24px 14px 0; }
.sec-label {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 9px;
  font-weight: 500;
  letter-spacing: 3px;
  color: var(--ink-faint);
  text-transform: uppercase;
  padding: 0 2px;
  margin-bottom: 10px;
}
.sec-label::after { content: ''; flex: 1; height: .5px; background: var(--line); }

/* ── Cards ── */
.card {
  background: var(--paper-card);
  border-radius: var(--r);
  border: .5px solid var(--line);
  padding: 16px 16px 14px;
  margin-bottom: 10px;
  position: relative;
  overflow: hidden;
}
.card::before {
  content: '';
  position: absolute;
  left: 0; top: 0; bottom: 0;
  width: 3px;
}
.card--blue::before  { background: var(--blue); }
.card--gold::before  { background: var(--gold); }
.card--teal::before  { background: var(--teal); }
.card--coral::before { background: var(--coral); }
.card--featured { border: 1.5px solid rgba(26,95,168,.28); background: #f9fcff; }
.card--featured-gold { border: 1.5px solid rgba(154,112,0,.28); background: #fdfbf5; }

.card-top {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 8px;
  margin-bottom: 1px;
}
.badge {
  font-size: 9px;
  font-weight: 500;
  letter-spacing: .5px;
  padding: 3px 9px;
  border-radius: 20px;
  flex-shrink: 0;
  margin-top: 3px;
}
.b-blue  { background: var(--blue-soft); color: #0a3d6b; }
.b-gold  { background: var(--gold-soft); color: #5a4000; }
.b-teal  { background: var(--teal-soft); color: var(--teal); }
.b-coral { background: var(--coral-soft); color: #7a2e0a; }

.card-name {
  font-family: var(--serif);
  font-size: 24px;
  font-weight: 400;
  color: var(--ink);
  letter-spacing: .5px;
  line-height: 1.05;
}
.card-sub {
  font-family: var(--serif);
  font-size: 12px;
  font-style: italic;
  color: var(--ink-faint);
  margin: 2px 0 10px;
}

.rows { display: flex; flex-direction: column; gap: 5px; margin-bottom: 13px; }
.row {
  font-size: 12.5px;
  color: var(--ink-soft);
  display: flex;
  align-items: baseline;
  gap: 7px;
  line-height: 1.45;
}
.row-icon { font-size: 13px; flex-shrink: 0; }
.row small { font-size: 10.5px; color: var(--ink-faint); margin-left: 2px; }

.card-foot {
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
  gap: 8px;
}
.price {
  font-family: var(--serif);
  font-size: 30px;
  font-weight: 400;
  color: var(--ink);
  line-height: 1;
}
.price sub {
  font-size: 12px;
  font-weight: 300;
  color: var(--ink-faint);
  font-family: var(--sans);
  vertical-align: baseline;
  margin-left: 2px;
}
.opts { display: flex; flex-wrap: wrap; gap: 4px; justify-content: flex-end; max-width: 52%; }
.opt {
  font-size: 10px;
  padding: 3px 8px;
  border: .5px solid var(--line);
  border-radius: 20px;
  color: var(--ink-faint);
  background: var(--paper-warm);
  white-space: nowrap;
}

/* ── 2-col grid ── */
.grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
.grid2 .card { margin-bottom: 0; }
.grid2 .card-name { font-size: 20px; }
.grid2 .card-foot { flex-direction: column; align-items: flex-start; gap: 5px; }
.grid2 .opts { max-width: 100%; justify-content: flex-start; }

.divider { border: none; border-top: .5px solid var(--line); margin: 0 14px; }

/* ── Dessert bar ── */
.dessert {
  margin: 20px 14px 0;
  background: var(--paper-warm);
  border-radius: var(--r-sm);
  border: .5px solid var(--line);
  padding: 12px 15px;
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 12.5px;
  color: var(--ink-soft);
}
.dessert strong { color: var(--ink); font-weight: 500; }

.bottom { height: calc(28px + env(safe-area-inset-bottom, 0px)); }

/* ── Responsive ── */
@media (max-width: 375px) {
  .grid2 { grid-template-columns: 1fr; }
  .grid2 .card-foot { flex-direction: row; align-items: flex-end; }
  .grid2 .opts { max-width: 55%; justify-content: flex-end; }
  .hero-title { font-size: 50px; }
}

/* ── Animations ── */
@media (prefers-reduced-motion: no-preference) {
  .hero-title  { animation: fadeUp .7s ease both; }
  .hero-eye    { animation: fadeUp .7s .08s ease both; }
  .hero-sub    { animation: fadeUp .6s .14s ease both; }
  .tea         { animation: fadeUp .5s .22s ease both; }
  .card        { animation: fadeUp .5s ease both; }

  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
  }
}
</style>
</head>
<body>

{{-- Hero --}}
<header class="hero">
  <p class="hero-eye">Menzah 9 — Tunis</p>
  <h1 class="hero-title">Söya<em>.</em></h1>
  <p class="hero-sub">Craft Ramen &amp; Gyoza</p>
  <div class="hero-line"></div>
</header>

{{-- Tea banner --}}
<div class="tea">
  <span class="tea-icon">🍵</span>
  <div class="tea-txt">
    <strong>Thé japonais glacé maison — inclus dans chaque menu</strong>
    Servi dès votre arrivée — 自家製冷たい日本茶つき
    <div class="tea-arabizi">saha! — صحة</div>
  </div>
</div>

{{-- Ramen --}}
<section class="section">
  <p class="sec-label">🍜 L'Expérience Ramen</p>

  <div class="card card--blue card--featured">
    <div class="card-top">
      <h2 class="card-name">THE CRAFT</h2>
      <span class="badge b-blue">Signature</span>
    </div>
    <p class="card-sub">L'essentiel Söya. — notre meilleur</p>
    <div class="rows">
      <div class="row"><span class="row-icon">🥗</span> Salade + Gyoza maison 4 pcs</div>
      <div class="row"><span class="row-icon">🍜</span> Ramen au choix</div>
    </div>
    <div class="card-foot">
      <div class="price">39 DT<sub>/ pers.</sub></div>
      <div class="opts">
        <span class="opt">Miso Chashu</span>
        <span class="opt">Miso Crevettes</span>
        <span class="opt">Tan-Tan Épicé</span>
        <span class="opt">Malâ Mix</span>
      </div>
    </div>
  </div>
</section>

<div class="divider"></div>

{{-- Riz --}}
<section class="section">
  <p class="sec-label">🍚 L'Expérience Riz</p>

  <div class="grid2">
    <div class="card card--gold card--featured-gold">
      <div class="card-top">
        <h2 class="card-name">TOKYO<br>GOLD<br>CURRY</h2>
        <span class="badge b-gold">Killer</span>
      </div>
      <p class="card-sub">Le curry légendaire de Tokyo</p>
      <div class="rows">
        <div class="row"><span class="row-icon">🥗</span> Salade + Soupe miso</div>
        <div class="row"><span class="row-icon">🍛</span> Curry katsu poulet</div>
      </div>
      <div class="card-foot">
        <div class="price">35 DT<sub>/ pers.</sub></div>
        <div class="opts">
          <span class="opt">+4DT crevettes</span>
          <span class="opt">-4DT véggi</span>
        </div>
      </div>
    </div>

    <div class="card card--gold">
      <div class="card-top">
        <h2 class="card-name">LE BOWL<br>ROZA</h2>
        <span class="badge b-gold">roza روزة</span>
      </div>
      <p class="card-sub">Ton bol, ton choix</p>
      <div class="rows">
        <div class="row"><span class="row-icon">🥗</span> Salade + Soupe miso</div>
        <div class="row"><span class="row-icon">🍱</span> Donburi au choix</div>
      </div>
      <div class="card-foot">
        <div class="price">32 DT<sub>/ pers.</sub></div>
        <div class="opts">
          <span class="opt">Katsu Poulet</span>
          <span class="opt">Mabô Poulet</span>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="divider"></div>

{{-- Gyoza --}}
<section class="section">
  <p class="sec-label">🥟 L'Expérience Gyoza</p>

  <div class="grid2">
    <div class="card card--teal">
      <div class="card-top">
        <h2 class="card-name">GYOZA<br>FESTIN</h2>
        <span class="badge b-teal">kol kol! كل</span>
      </div>
      <p class="card-sub">La fête de la gyoza maison</p>
      <div class="rows">
        <div class="row"><span class="row-icon">🥗</span> Salade</div>
        <div class="row"><span class="row-icon">🥟</span> Gyoza grillés 12 pcs<small>viande 6 + crevettes 6</small></div>
        <div class="row"><span class="row-icon">🍙</span> Onigiri + 2 sauces maison</div>
      </div>
      <div class="card-foot">
        <div class="price">38 DT<sub>/ pers.</sub></div>
      </div>
    </div>

    <div class="card card--coral">
      <div class="card-top">
        <h2 class="card-name">DUO<br>SÖYA</h2>
        <span class="badge b-coral">marhba! مرحبا</span>
      </div>
      <p class="card-sub">Pour un moment à deux</p>
      <div class="rows">
        <div class="row"><span class="row-icon">🍵</span> Thé glacé × 2</div>
        <div class="row"><span class="row-icon">🍽️</span> Grand plateau partagé</div>
        <div class="row"><span class="row-icon">⭐</span> 2 plats au choix</div>
      </div>
      <div class="card-foot">
        <div class="price">72 DT<sub>/ 2 pers.</sub></div>
      </div>
    </div>
  </div>
</section>

{{-- Dessert --}}
<div class="dessert">
  <span style="font-size:20px">🍮</span>
  <div><strong>Desserts — en option</strong> — proposés par notre équipe après le repas</div>
</div>

<div class="bottom"></div>

</body>
</html>
