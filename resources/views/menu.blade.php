<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $tenant->name ?? 'Menu' }} | Order</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;1,700&family=Montserrat:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/sass/menu.scss'])

    <style>
        :root {
            /* データベースから取得したカラーをセット */
            --theme-primary: {{ $tenant->theme_primary ?? '#e60012' }};
            --theme-bg: {{ $tenant->theme_bg ?? '#eaedf0' }};
        }

        .nav-back-fixed {
            position: fixed;
            top: 16px;
            left: 16px;
            z-index: 1000;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
            opacity: 0.8;
            transition: all 0.3s ease;
            mix-blend-mode: difference;
            color: #fff;
        }

        .nav-back-fixed:hover {
            opacity: 1;
            transform: translateX(-2px);
        }

        .nav-back-text {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 0.7rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }
    </style>
</head>

<body class="pb-32 bg-[var(--theme-bg)] text-[#110A08] transition-colors duration-500">

    <a href="{{ url('/') }}" class="nav-back-fixed">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
            stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        <span class="nav-back-text">{{ $tenant->name ?? 'Home' }}</span>
    </a>

    {{-- 機能フラグ：雨エフェクト --}}
    @if ($features['has_rain_effect'] ?? false)
        <div id="soy-rain-container"></div>
    @endif

    <div
        class="sticky top-0 z-40 bg-[var(--theme-bg)]/95 backdrop-blur-md shadow-sm border-b border-[#A3B8C9]/30 transition-all duration-300">
        <header class="pt-3 pb-1 px-4 text-center">
            <a href="{{ url('/') }}" class="inline-block hover:opacity-70 transition-opacity">
                <h1 class="serif text-xl font-bold tracking-tight text-[#110A08]">{{ $tenant->name ?? 'Store' }}<span
                        class="text-[var(--theme-primary)]">.</span></h1>
            </a>
        </header>
        <div class="flex gap-6 px-4 py-3 overflow-x-auto category-nav items-center">
            @foreach ($categories as $category)
                <a href="#cat-{{ $category->id }}"
                    class="nav-link whitespace-nowrap text-[10px] font-bold tracking-[0.15em] uppercase text-[#A3B8C9] transition-all duration-200"
                    data-target="cat-{{ $category->id }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </div>

    <main class="px-0 mt-4 max-w-xl mx-auto">
        @foreach ($categories as $category)
            <section id="cat-{{ $category->id }}" class="section-spy pt-4 pb-6">
                <div class="px-4 mb-3 flex items-center gap-2 sticky top-[105px] z-30 pointer-events-none">
                    <div
                        class="bg-[#110A08]/95 backdrop-blur px-4 py-1.5 rounded-full shadow-md border border-[#C5A059]/30">
                        <h2 class="text-[10px] font-bold uppercase tracking-widest text-[#C5A059]">
                            {{ $category->name }}</h2>
                    </div>
                </div>

                <div class="flex flex-col gap-3 px-4">
                    @foreach ($category->products as $product)
                        <div onclick="openProductModal({{ $product->id }})"
                            class="relative flex items-center gap-3 p-3 bg-white rounded-2xl shadow-sm border border-transparent hover:border-[var(--theme-primary)] active:scale-[0.98] transition-all cursor-pointer group h-[96px]">

                            <div
                                class="w-[72px] h-[72px] shrink-0 bg-[var(--theme-bg)] rounded-xl overflow-hidden relative">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div
                                        class="w-full h-full flex items-center justify-center text-[9px] text-[#A3B8C9] font-bold">
                                        NO IMG</div>
                                @endif
                            </div>

                            <div class="flex-1 min-w-0 flex flex-col justify-center h-full py-1">
                                <h3 class="serif text-[15px] font-bold leading-tight text-[#110A08] mb-1 truncate pr-2">
                                    {{ $product->name }}</h3>
                                <p class="text-[10px] text-[#A3B8C9] line-clamp-1 leading-tight mb-1.5">
                                    {!! strip_tags($product->description) !!}</p>
                                @if ($product->productVariants->count() > 0)
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-[4px] text-[8px] font-bold tracking-wider bg-[var(--theme-bg)] text-[#110A08] self-start border border-[#A3B8C9]/30">
                                        {{ $product->productVariants->count() }} Styles
                                    </span>
                                @endif
                            </div>

                            <div class="flex flex-col justify-between items-end h-full py-1 pl-2 shrink-0">
                                <span class="font-mono font-bold text-[14px] text-[#110A08]">
                                    {{ number_format($product->price, 3) }}
                                    @if ($product->productVariants->where('is_required', true)->count() > 0)
                                        <span class="text-[10px] text-[#A3B8C9] font-normal">~</span>
                                    @endif
                                </span>
                                <button
                                    class="w-8 h-8 rounded-full bg-[var(--theme-bg)] text-[#110A08] flex items-center justify-center group-hover:bg-[var(--theme-primary)] group-hover:text-white transition-colors duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="12" y1="5" x2="12" y2="19"></line>
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endforeach
    </main>

    <div id="cart-bar"
        class="fixed bottom-6 left-4 right-4 max-w-xl mx-auto bg-[#110A08] border border-[#C5A059]/30 text-white p-2 pl-6 rounded-full flex justify-between items-center shadow-[0_20px_40px_rgba(17,10,8,0.6)] z-[1000] hidden animate-[fadeInUp_0.3s_ease-out]">
        <div class="flex flex-col justify-center">
            <span class="text-[9px] tracking-[0.2em] text-[#C5A059]/70 uppercase font-bold">Total</span>
            <div class="font-mono font-bold text-[22px] leading-none mt-0.5 flex items-baseline gap-1 text-[#C5A059]">
                <span id="cart-total">0.000</span><span
                    class="text-[10px] font-sans font-medium text-[#C5A059]/70">DT</span>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <div
                class="flex items-center justify-center w-9 h-9 bg-[#C5A059]/20 rounded-full text-xs font-bold text-[#C5A059] border border-[#C5A059]/30">
                <span id="cart-count">0</span>
            </div>
            <button onclick="App.openCheckout()"
                class="group flex items-center gap-2 bg-[var(--theme-primary)] text-white px-6 py-3.5 rounded-full text-[11px] font-bold tracking-[0.2em] uppercase hover:brightness-90 shadow-lg active:scale-95 transition-all">
                <span>Check Out</span>
                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                    stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </button>
        </div>
    </div>

    <div id="product-modal"
        class="fixed inset-0 bg-[#110A08]/80 backdrop-blur-sm z-[2000] hidden items-end justify-center sm:items-center">
        <div
            class="bg-[var(--theme-bg)] w-full max-w-lg rounded-t-[2rem] sm:rounded-3xl overflow-hidden shadow-2xl max-h-[92vh] flex flex-col relative">
            <div class="p-6 pb-4 shrink-0 relative z-10 bg-white border-b border-[#A3B8C9]/30">
                <button onclick="closeModal()"
                    class="absolute top-5 right-5 w-8 h-8 flex items-center justify-center rounded-full bg-[var(--theme-bg)] text-[#110A08] hover:bg-[#A3B8C9]/30 transition-colors">✕</button>
                <h2 id="modal-product-name" class="serif text-2xl font-bold text-[#110A08] pr-10 leading-tight mb-2">
                </h2>
                <div class="space-y-2">
                    <p id="modal-description" class="text-xs text-[#110A08]/70 leading-relaxed"></p>
                    <p id="modal-ingredients"
                        class="text-[9px] text-[#A3B8C9] uppercase tracking-wider border-l-2 border-[var(--theme-primary)] pl-2 font-bold">
                    </p>
                </div>
            </div>

            <div id="modal-options" class="p-6 overflow-y-auto grow bg-[var(--theme-bg)]"></div>

            <div class="p-5 border-t border-[#A3B8C9]/30 shrink-0 bg-white relative z-20">
                {{-- 機能フラグ：醤油ちゃんマスコット --}}
                @if ($features['has_mascot'] ?? false)
                    <div id="soy-character"
                        class="hidden absolute -top-20 left-1/2 flex-col items-center pointer-events-none z-30"
                        style="transform: translateX(-50%);">
                        <div
                            class="bg-[var(--theme-primary)] text-white text-[10px] font-bold py-1 px-3 rounded-full mb-2 shadow-lg whitespace-nowrap animate-bounce">
                            Please select a style.
                        </div>
                        <svg width="50" height="80" viewBox="0 0 60 90" class="drop-shadow-xl soy-shake">
                            <path d="M15,20 L45,20 L42,5 L18,5 Z" fill="var(--theme-primary)" />
                            <path d="M18,20 L42,20 L50,80 C50,85 45,90 30,90 C15,90 10,85 10,80 L18,20 Z"
                                fill="#110A08" />
                            <rect x="20" y="35" width="20" height="30" fill="white" rx="2" />
                            <circle cx="30" cy="50" r="5" fill="var(--theme-primary)" />
                        </svg>
                    </div>
                @endif
                <button id="add-to-cart-btn" onclick="confirmProduct()"
                    class="w-full bg-[var(--theme-primary)] text-white py-4 rounded-xl font-bold tracking-[0.15em] text-[12px] hover:opacity-80 transition-colors shadow-lg flex justify-center items-center gap-2">
                    ADD TO ORDER
                </button>
            </div>
        </div>
    </div>

    @include('parts.checkout-modal')

    <div id="order-status-bar"
        class="fixed bottom-0 left-0 right-0 bg-[#110A08] shadow-[0_-10px_30px_rgba(0,0,0,0.5)] z-[1500] transform translate-y-full transition-transform duration-500 rounded-t-3xl overflow-hidden hidden flex-col max-w-xl mx-auto border border-[#C5A059]/20">
        <div class="text-white p-4 flex items-center justify-between cursor-pointer"
            onclick="document.getElementById('order-status-details').classList.toggle('hidden')">
            <div class="flex items-center gap-3">
                <div
                    class="w-10 h-10 rounded-full bg-[var(--theme-primary)] flex items-center justify-center animate-pulse shadow-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-[11px] font-bold tracking-widest uppercase text-[#C5A059]">Waiting Confirmation
                    </div>
                    <div class="text-[10px] text-[#A3B8C9] mt-0.5">Order <span id="status-order-number"
                            class="text-white font-mono font-bold"></span></div>
                </div>
            </div>
            <svg class="w-5 h-5 text-[#C5A059]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
            </svg>
        </div>
        <div id="order-status-details" class="p-6 bg-white hidden">
            <p class="text-xs text-[#110A08] leading-relaxed font-medium">
                Please wait for our staff to confirm.<br>
                <span class="text-[var(--theme-primary)] font-bold block mt-2">If you do not receive a reply within 10
                    minutes, kindly call us directly.</span>
                <span class="text-[10px] text-[#A3B8C9] block mt-1">(Messages may be delayed during peak hours)</span>
            </p>
            <a href="tel:+{{ $tenant->whatsapp_number ?? '216557786656' }}"
                class="mt-5 w-full bg-white border border-[#110A08] text-[#110A08] py-3.5 rounded-xl font-bold text-[11px] tracking-widest flex justify-center items-center gap-2 hover:bg-[#110A08] hover:text-[#C5A059] transition-all">
                <i class="bi bi-telephone-fill"></i> CALL : +{{ $tenant->whatsapp_number ?? '216 55 778 6656' }}
            </a>
            <div class="text-center mt-4">
                <button onclick="App.clearOrderStatus()"
                    class="text-[#A3B8C9] hover:text-[#110A08] text-[10px] font-bold tracking-wider uppercase underline decoration-[var(--theme-bg)] underline-offset-4">Hide
                    Tracker</button>
            </div>
        </div>
    </div>

    <script>
        // JSに店舗名とWhatsApp番号を渡す
        window.TENANT_STORE_NAME = "{{ $tenant->name ?? 'Söya Menzah9' }}";
        window.TENANT_WA_NUMBER = "{{ $tenant->whatsapp_number ?? '216557786656' }}";
        window.ALL_PRODUCTS = @json($categories->flatMap->products);

        const openProductModal = (id) => App.openModal(id);
        const closeModal = () => App.close();
        const confirmProduct = () => App.confirm();

        // 雨エフェクトのJS (フラグがONの時だけ実行)
        @if ($features['has_rain_effect'] ?? false)
            let lastScrollY = 0;
            let soyRainContainer = document.getElementById('soy-rain-container');
            let dropCooldown = false;

            window.addEventListener('scroll', () => {
                const currentScrollY = window.scrollY;
                const delta = Math.abs(currentScrollY - lastScrollY);
                if (delta > 10 && !dropCooldown) {
                    createSoyDrop();
                    dropCooldown = true;
                    setTimeout(() => {
                        dropCooldown = false;
                    }, 100);
                }
                lastScrollY = currentScrollY;
            });

            function createSoyDrop() {
                const drop = document.createElement('div');
                drop.className = 'soy-drop animate-drip';
                drop.style.left = (Math.random() * window.innerWidth) + 'px';
                drop.style.transform = `rotate(45deg) scale(${0.5 + Math.random() * 0.5})`;
                if (soyRainContainer) soyRainContainer.appendChild(drop);
                setTimeout(() => {
                    drop.remove();
                }, 1200);
            }
        @endif

        // スクロール時のカテゴリハイライト
        document.addEventListener('DOMContentLoaded', () => {
            const sections = document.querySelectorAll('.section-spy');
            const navLinks = document.querySelectorAll('.nav-link');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        navLinks.forEach(link => link.classList.remove('active'));
                        const activeLink = document.querySelector(
                            `.nav-link[href="#${entry.target.id}"]`);
                        if (activeLink) {
                            activeLink.classList.add('active');
                            activeLink.scrollIntoView({
                                behavior: 'smooth',
                                block: 'nearest',
                                inline: 'center'
                            });
                        }
                    }
                });
            }, {
                rootMargin: '-20% 0px -60% 0px'
            });
            sections.forEach(section => observer.observe(section));

            if (typeof App !== 'undefined') App.checkActiveOrder();
        });
    </script>
    <script src="{{ asset('js/menu.js') }}"></script>
</body>

</html>
