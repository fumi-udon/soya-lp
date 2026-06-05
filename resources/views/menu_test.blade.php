{{-- resources/views/menu_test.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<meta name="theme-color" content="#0a0a08">
<title>Söya. — Craft Ramen & Gyoza</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
/* ── reset & base ── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  --ink:        #0a0a08;
  --ink-soft:   #3a3935;
  --ink-faint:  #8a8880;
  --paper:      #f7f5f0;
  --paper-warm: #efece4;
  --paper-card: #faf9f6;
  --red:        #c41e1e;
  --red-soft:   #f5e8e8;
  --gold:       #b8860b;
  --gold-soft:  #f5f0e0;
  --teal:       #0f6e56;
  --teal-soft:  #e4f2ee;
  --coral:      #c45c2e;
  --coral-soft: #f5ede8;
  --line:       rgba(10,10,8,.10);
  --r:          12px;
  --r-sm:       8px;
  --serif:      'Cormorant Garamond', Georgia, serif;
  --sans:       'DM Sans', sans-serif;
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

/* ── hero header ── */
.hero {
  background: var(--ink);
  padding: 56px 24px 40px;
  text-align: center;
  position: relative;
  overflow: hidden;
}

.hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background:
    radial-gradient(ellipse 60% 40% at 30% 80%, rgba(196,30,30,.18) 0%, transparent 70%),
    radial-gradient(ellipse 50% 50% at 75% 20%, rgba(184,134,11,.12) 0%, transparent 70%);
  pointer-events: none;
}

.hero-eyebrow {
  font-family: var(--sans);
  font-size: 10px;
  font-weight: 500;
  letter-spacing: 4px;
  color: var(--ink-faint);
  text-transform: uppercase;
  margin-bottom: 12px;
  opacity: .7;
}

.hero-title {
  font-family: var(--serif);
  font-size: 56px;
  font-weight: 300;
  color: #f7f5f0;
  letter-spacing: 6px;
  line-height: 1;
  margin-bottom: 8px;
}

.hero-title span {
  color: var(--red);
}

.hero-sub {
  font-family: var(--serif);
  font-size: 14px;
  font-weight: 300;
  font-style: italic;
  color: rgba(247,245,240,.45);
  letter-spacing: 1px;
}

.hero-divider {
  width: 32px;
  height: 1px;
  background: rgba(247,245,240,.20);
  margin: 20px auto 0;
}

/* ── tea banner ── */
.tea-banner {
  background: var(--teal);
  padding: 14px 20px;
  display: flex;
  align-items: center;
  gap: 12px;
}

.tea-icon {
  font-size: 20px;
  flex-shrink: 0;
}

.tea-text {
  font-size: 12px;
  color: rgba(255,255,255,.85);
  line-height: 1.5;
}

.tea-text strong {
  color: #fff;
  font-weight: 500;
  display: block;
  font-size: 13px;
  margin-bottom: 1px;
}

/* ── section ── */
.section {
  padding: 28px 16px 0;
}

.section:last-of-type {
  padding-bottom: 32px;
}

.section-label {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 10px;
  font-weight: 500;
  letter-spacing: 3px;
  color: var(--ink-faint);
  text-transform: uppercase;
  padding: 0 4px;
  margin-bottom: 12px;
}

.section-label::after {
  content: '';
  flex: 1;
  height: .5px;
  background: var(--line);
}

/* ── cards ── */
.card {
  background: var(--paper-card);
  border-radius: var(--r);
  border: .5px solid var(--line);
  padding: 18px 18px 16px;
  margin-bottom: 10px;
  position: relative;
  overflow: hidden;
}

.card::before {
  content: '';
  position: absolute;
  left: 0; top: 0; bottom: 0;
  width: 3px;
  border-radius: var(--r) 0 0 var(--r);
}

.card--signature::before { background: #378ADD; }
.card--amber::before     { background: var(--gold); }
.card--teal::before      { background: var(--teal); }
.card--coral::before     { background: var(--coral); }
.card--featured {
  border: 1.5px solid rgba(55,138,221,.35);
  background: #fafcff;
}

.card-header {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 8px;
  margin-bottom: 2px;
}

.badge {
  font-size: 10px;
  font-weight: 500;
  letter-spacing: .5px;
  padding: 3px 10px;
  border-radius: 20px;
  flex-shrink: 0;
  margin-top: 2px;
}

.badge--blue   { background: #E6F1FB; color: #0C447C; }
.badge--amber  { background: var(--gold-soft); color: #7a5800; }
.badge--teal   { background: var(--teal-soft); color: var(--teal); }
.badge--coral  { background: var(--coral-soft); color: #8b3a18; }

.card-title {
  font-family: var(--serif);
  font-size: 22px;
  font-weight: 400;
  color: var(--ink);
  letter-spacing: .5px;
  line-height: 1.1;
}

.card-sub {
  font-size: 11px;
  color: var(--ink-faint);
  font-style: italic;
  margin: 3px 0 12px;
  font-family: var(--serif);
}

.card-rows {
  display: flex;
  flex-direction: column;
  gap: 5px;
  margin-bottom: 14px;
}

.card-row {
  font-size: 13px;
  color: var(--ink-soft);
  display: flex;
  align-items: baseline;
  gap: 7px;
  line-height: 1.45;
}

.card-row-icon {
  font-size: 14px;
  flex-shrink: 0;
}

.card-footer {
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
  gap: 8px;
}

.price {
  font-family: var(--serif);
  font-size: 28px;
  font-weight: 400;
  color: var(--ink);
  line-height: 1;
}

.price sub {
  font-size: 13px;
  font-weight: 300;
  color: var(--ink-faint);
  font-family: var(--sans);
  vertical-align: baseline;
  margin-left: 2px;
}

.opts {
  display: flex;
  flex-wrap: wrap;
  gap: 5px;
  justify-content: flex-end;
  max-width: 55%;
}

.opt {
  font-size: 10px;
  padding: 3px 9px;
  border: .5px solid var(--line);
  border-radius: 20px;
  color: var(--ink-faint);
  background: var(--paper-warm);
  white-space: nowrap;
}

/* ── side-by-side on wider phones ── */
.grid-2 {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 10px;
}

.grid-2 .card {
  margin-bottom: 0;
}

.grid-2 .card-title {
  font-size: 19px;
}

.grid-2 .card-footer {
  flex-direction: column;
  align-items: flex-start;
  gap: 6px;
}

.grid-2 .opts {
  max-width: 100%;
  justify-content: flex-start;
}

/* ── dessert footer ── */
.dessert-bar {
  margin: 24px 16px 0;
  background: var(--paper-warm);
  border-radius: var(--r-sm);
  border: .5px solid var(--line);
  padding: 13px 16px;
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 13px;
  color: var(--ink-soft);
}

.dessert-bar strong {
  color: var(--ink);
  font-weight: 500;
}

/* ── bottom safe area ── */
.bottom-pad {
  height: calc(16px + env(safe-area-inset-bottom, 0px));
}

/* ── animations ── */
@media (prefers-reduced-motion: no-preference) {
  .hero-title   { animation: fadeUp .7s ease both; }
  .hero-eyebrow { animation: fadeUp .7s .1s ease both; }
  .hero-sub     { animation: fadeUp .7s .15s ease both; }
  .tea-banner   { animation: fadeUp .5s .25s ease both; }
  .card         { animation: fadeUp .5s ease both; }

  .section:nth-child(2) .card { animation-delay: .1s; }
  .section:nth-child(3) .card:nth-child(1) { animation-delay: .15s; }
  .section:nth-child(3) .card:nth-child(2) { animation-delay: .20s; }
  .section:nth-child(4) .card:nth-child(1) { animation-delay: .20s; }
  .section:nth-child(4) .card:nth-child(2) { animation-delay: .25s; }

  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
  }
}

/* ── narrow phones: stack grid-2 ── */
@media (max-width: 380px) {
  .grid-2 { grid-template-columns: 1fr; }
  .grid-2 .card { margin-bottom: 0; }
  .grid-2 .card-footer { flex-direction: row; align-items: flex-end; }
  .grid-2 .opts { max-width: 55%; justify-content: flex-end; }
  .hero-title { font-size: 48px; }
}
</style>
</head>
<body>

{{-- Hero --}}
<div class="hero">
  <p class="hero-eyebrow">Menzah 9 — Tunis</p>
  <h1 class="hero-title">Söya<span>.</span></h1>
  <p class="hero-sub">Craft Ramen &amp; Gyoza</p>
  <div class="hero-divider"></div>
</div>

{{-- Tea banner --}}
<div class="tea-banner">
  <span class="tea-icon">🍵</span>
  <div class="tea-text">
    <strong>自家製 冷たい日本茶、全メニューに含まれます</strong>
    着席後すぐにお出しします — inclus dans chaque menu
  </div>
</div>

{{-- Section: Ramen --}}
<div class="section">
  <p class="section-label">🍜 ラーメン体験</p>

  <div class="card card--signature card--featured">
    <div class="card-header">
      <h2 class="card-title">Menu Craft</h2>
      <span class="badge badge--blue">Signature</span>
    </div>
    <p class="card-sub">Söya. の全てが詰まった一杯</p>
    <div class="card-rows">
      <div class="card-row"><span class="card-row-icon">🥗</span> サラダ + 自家製餃子 4個</div>
      <div class="card-row"><span class="card-row-icon">🍜</span> ラーメン（下記から選択）</div>
    </div>
    <div class="card-footer">
      <div class="price">39 DT<sub>/ 1名</sub></div>
      <div class="opts">
        <span class="opt">味噌チャーシュー</span>
        <span class="opt">味噌海老</span>
        <span class="opt">担々麺</span>
        <span class="opt">まぜそば</span>
      </div>
    </div>
  </div>
</div>

{{-- Section: Rice --}}
<div class="section">
  <p class="section-label">🍚 ライス体験</p>

  <div class="grid-2">
    <div class="card card--amber card--featured">
      <div class="card-header">
        <h2 class="card-title">Katsu<br>Curry</h2>
        <span class="badge badge--amber">Killer</span>
      </div>
      <p class="card-sub">東京の味、チュニジアで</p>
      <div class="card-rows">
        <div class="card-row"><span class="card-row-icon">🥗</span> サラダ + 味噌汁</div>
        <div class="card-row"><span class="card-row-icon">🍛</span> チキンカツカレー</div>
      </div>
      <div class="card-footer">
        <div class="price">35 DT<sub>/ 1名</sub></div>
        <div class="opts">
          <span class="opt">+4DT 海老</span>
          <span class="opt">-4DT ベジ</span>
        </div>
      </div>
    </div>

    <div class="card card--amber">
      <div class="card-header">
        <h2 class="card-title">Tokyo<br>Bowl</h2>
        <span class="badge badge--amber">どんぶり</span>
      </div>
      <p class="card-sub">日本の定食スタイル</p>
      <div class="card-rows">
        <div class="card-row"><span class="card-row-icon">🥗</span> サラダ + 味噌汁</div>
        <div class="card-row"><span class="card-row-icon">🍱</span> チキンカツ丼</div>
      </div>
      <div class="card-footer">
        <div class="price">32 DT<sub>/ 1名</sub></div>
      </div>
    </div>
  </div>
</div>

{{-- Section: Gyoza --}}
<div class="section">
  <p class="section-label">🥟 餃子体験</p>

  <div class="grid-2">
    <div class="card card--teal">
      <div class="card-header">
        <h2 class="card-title">Gyoza<br>Plate</h2>
        <span class="badge badge--teal">食べ比べ</span>
      </div>
      <p class="card-sub">4種の調理法を一皿で</p>
      <div class="card-rows">
        <div class="card-row"><span class="card-row-icon">🥗</span> サラダ</div>
        <div class="card-row"><span class="card-row-icon">🥟</span> 餃子 8個<br><small style="color:var(--ink-faint);font-size:11px">焼・スープ・揚・麻婆</small></div>
        <div class="card-row"><span class="card-row-icon">🍙</span> おにぎり + ソース 2種</div>
      </div>
      <div class="card-footer">
        <div class="price">38 DT<sub>/ 1名</sub></div>
      </div>
    </div>

    <div class="card card--coral">
      <div class="card-header">
        <h2 class="card-title">Duo<br>Söya</h2>
        <span class="badge badge--coral">2名様</span>
      </div>
      <p class="card-sub">デートに最適な特別コース</p>
      <div class="card-rows">
        <div class="card-row"><span class="card-row-icon">🍽️</span> 大皿シェア前菜</div>
        <div class="card-row"><span class="card-row-icon">🍜</span> メイン 2品（自由選択）</div>
      </div>
      <div class="card-footer">
        <div class="price">72 DT<sub>/ 2名</sub></div>
      </div>
    </div>
  </div>
</div>

{{-- Dessert bar --}}
<div class="dessert-bar">
  <span style="font-size:20px">🍮</span>
  <div><strong>デザート別売り</strong> — 食後にスタッフよりご案内します</div>
</div>

<div class="bottom-pad"></div>

</body>
</html>