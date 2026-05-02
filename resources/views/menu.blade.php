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
        html {
            scroll-behavior: smooth;
        }

        :root {
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
            opacity: 0.8;
            transition: opacity 0.3s ease;
            mix-blend-mode: difference;
            color: #fff;
        }

        .nav-back-fixed:hover {
            opacity: 1;
        }

        /* スクロールバー非表示 */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .nav-link.active-nav {
            color: var(--theme-primary);
        }
    </style>
</head>

<body class="pb-32 bg-[var(--theme-bg)] text-[#110A08] transition-colors duration-500">

    <a href="{{ $homeUrl ?? url('/') }}" class="nav-back-fixed p-2 -ml-2">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
            stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
    </a>

    <div class="sticky top-0 z-40 bg-[var(--theme-bg)]/95 backdrop-blur-md shadow-sm border-b border-[#A3B8C9]/30">
        <header class="pt-3 pb-1 px-4 text-center">
            <a href="#" class="inline-block hover:opacity-70 transition-opacity">
                <h1 class="serif text-xl font-bold tracking-tight text-[#110A08]">{{ $tenant->name ?? 'Store' }}<span
                        class="text-[var(--theme-primary)]">.</span></h1>
            </a>
        </header>
        <div class="flex gap-6 px-4 py-3 overflow-x-auto hide-scrollbar items-center">
            @foreach ($categories as $category)
                <a href="#cat-{{ $category->id }}"
                    class="nav-link whitespace-nowrap text-[10px] font-bold tracking-[0.15em] uppercase text-[#A3B8C9]"
                    data-target="cat-{{ $category->id }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </div>

    <main class="px-0 mt-4 max-w-xl mx-auto">
        @foreach ($categories as $category)
            <section id="cat-{{ $category->id }}" class="section-spy pt-4 pb-6 scroll-mt-[100px]">
                <div class="px-4 mb-3 flex items-center gap-2 sticky top-[70px] z-30 pointer-events-none">
                    <div
                        class="bg-white/95 backdrop-blur px-4 py-1.5 rounded-full shadow-sm border border-[var(--theme-primary)]">
                        <h2 class="text-[10px] font-bold uppercase tracking-widest text-[var(--theme-primary)]">
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
        class="fixed bottom-6 left-4 right-4 max-w-xl mx-auto bg-[#110A08] border border-white/20 p-2 pl-6 rounded-full flex justify-between items-center shadow-[0_15px_40px_rgba(0,0,0,0.3)] z-[1000] hidden">
        <div class="flex flex-col justify-center">
            <span class="text-[10px] tracking-[0.15em] text-white/60 uppercase font-bold">Total</span>
            <div class="font-mono font-bold text-[22px] leading-none mt-0.5 flex items-baseline gap-1 text-white">
                <span id="cart-total">0.000</span><span
                    class="text-[11px] font-sans font-medium text-white/60">DT</span>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <div
                class="flex items-center justify-center w-9 h-9 bg-white/10 border border-white/20 rounded-full text-xs font-bold text-white">
                <span id="cart-count">0</span>
            </div>
            <button onclick="App.openCheckout()"
                class="group flex items-center gap-2 bg-[var(--theme-primary)] text-white px-6 py-3.5 rounded-full text-[11px] font-bold tracking-[0.2em] uppercase hover:brightness-90 shadow-md active:scale-95 transition-all">
                <span style="text-shadow: 0 1px 2px rgba(0,0,0,0.2);">TO CART</span>
                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform"
                    style="filter: drop-shadow(0 1px 2px rgba(0,0,0,0.2));" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </button>
        </div>
    </div>

    <div id="product-modal"
        class="fixed inset-0 bg-[#110A08]/80 backdrop-blur-sm z-[2000] hidden items-end justify-center sm:items-center">

        {{--
            soy-character はモーダルカードの overflow-hidden に巻き込まれないよう
            カード div の兄要素として #product-modal 直下に配置する。
            left-1/2 + pyonJump アニメーション内の translate(-50%,Y) で水平中央揃えを維持。
        --}}
        <div id="soy-character"
            class="hidden absolute bottom-20 left-1/2 flex-col items-center pointer-events-none z-[2050]">
            <div
                class="bg-[var(--theme-primary)] text-white text-sm font-bold py-2 px-5 rounded-full mb-2 shadow-xl whitespace-nowrap">
                Please select a style ↑
            </div>
            <svg width="44" height="66" viewBox="0 0 60 90" class="drop-shadow-xl soy-shake">
                <path d="M15,20 L45,20 L42,5 L18,5 Z" fill="#e60012" />
                <path d="M18,20 L42,20 L50,80 C50,85 45,90 30,90 C15,90 10,85 10,80 L18,20 Z" fill="#2c1a16" />
                <rect x="20" y="35" width="20" height="30" fill="white" rx="2" />
                <circle cx="30" cy="50" r="5" fill="#e60012" />
                <path d="M45,30 L55,20 M55,30 L45,20" stroke="#e60012" stroke-width="3"
                    stroke-linecap="round" />
            </svg>
        </div>

        <div
            class="bg-[var(--theme-bg)] w-full max-w-lg rounded-t-[2rem] sm:rounded-3xl overflow-hidden shadow-2xl max-h-[92vh] flex flex-col relative">

            <div class="shrink-0 relative z-10 bg-white border-b border-[#A3B8C9]/30">
                <div class="relative w-full h-40 bg-[var(--theme-bg)]">
                    <img id="modal-product-image" src="" alt=""
                        class="w-full h-full object-cover hidden">
                    <div id="modal-no-image"
                        class="w-full h-full flex items-center justify-center text-[11px] tracking-widest text-[#A3B8C9] font-bold hidden">
                        NO IMAGE</div>
                    <button onclick="closeModal()"
                        class="absolute top-3 right-3 w-8 h-8 flex items-center justify-center rounded-full bg-white/90 backdrop-blur text-[#110A08] shadow-sm hover:bg-white transition-colors z-20">✕</button>
                </div>

                <div class="p-4 pb-2 bg-white">
                    <h2 id="modal-product-name" class="serif text-xl font-bold text-[#110A08] leading-tight mb-1.5">
                    </h2>
                    <div class="space-y-1.5">
                        <p id="modal-description" class="text-[11px] text-[#110A08]/70 leading-relaxed"></p>
                        <p id="modal-ingredients"
                            class="text-[9px] text-[#A3B8C9] uppercase tracking-wider border-l-2 border-[var(--theme-primary)] pl-2 font-bold">
                        </p>
                    </div>
                </div>
            </div>

            <div id="modal-options" class="px-4 py-3 overflow-y-auto grow bg-[var(--theme-bg)]"></div>

            <div
                class="p-3 border-t border-[#A3B8C9]/30 shrink-0 bg-white relative z-20 shadow-[0_-4px_10px_rgba(0,0,0,0.02)]">
                <button id="add-to-cart-btn" onclick="confirmProduct()"
                    class="w-full bg-[var(--theme-primary)] text-white py-3 rounded-xl font-bold tracking-[0.15em] text-[12px] hover:brightness-95 transition-all shadow-md flex justify-center items-center gap-2">
                    ADD TO ORDER — <span id="add-to-cart-price">0.000</span> DT
                </button>
            </div>
        </div>
    </div>

    @include('parts.checkout-modal')

    <div id="order-tracker-overlay"
        class="fixed inset-0 bg-[#110A08]/40 backdrop-blur-sm z-[1500] hidden items-center justify-center transition-opacity">
        <div id="order-tracker-expanded"
            class="bg-white w-[90%] max-w-sm rounded-3xl shadow-2xl p-6 flex flex-col items-center text-center relative transform transition-all scale-95 opacity-0">
            <button onclick="toggleOrderTracker(false)"
                class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full bg-[var(--theme-bg)] text-[#A3B8C9] hover:text-[var(--theme-primary)] transition-colors">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </button>

            <div
                class="w-16 h-16 rounded-full bg-[var(--theme-bg)] flex items-center justify-center mb-4 mt-2 border border-[var(--theme-primary)]/30">
                <svg class="w-8 h-8 text-[var(--theme-primary)] animate-pulse" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <h3 class="font-bold text-lg text-[#110A08] mb-1">Waiting Confirmation</h3>
            <p class="text-[11px] font-mono text-[#A3B8C9] mb-4">Order <span id="expanded-order-number"
                    class="font-bold text-[var(--theme-primary)]"></span></p>

            <p class="text-[13px] text-[#110A08] leading-relaxed font-medium mb-5">
                Your order is <strong class="text-[var(--theme-primary)]">not yet confirmed</strong>.<br>
                Waiting for staff confirmation.<br><br>
                If you don't receive a reply within 10 minutes, please contact the store directly.
            </p>

            <a href="tel:+{{ $tenant->whatsapp_number ?? '216557786656' }}"
                class="w-full bg-[var(--theme-bg)] text-[#110A08] py-3.5 rounded-xl font-bold text-[12px] tracking-widest flex justify-center items-center gap-2 hover:bg-[var(--theme-primary)] hover:text-white transition-all mb-4">
                <i class="bi bi-telephone-fill"></i> CALL : +{{ $tenant->whatsapp_number ?? '216 55 778 6656' }}
            </a>

            <button onclick="App.clearOrderStatus()"
                class="text-[#A3B8C9] hover:text-[#110A08] text-[10px] font-bold tracking-wider uppercase underline underline-offset-4">Cancel
                Tracker</button>
        </div>
    </div>

    <div id="order-tracker-minimized" onclick="toggleOrderTracker(true)"
        class="fixed bottom-6 left-1/2 transform -translate-x-1/2 bg-white border border-[var(--theme-primary)]/30 shadow-[0_10px_25px_rgba(0,0,0,0.1)] rounded-full px-5 py-3 z-[1400] hidden items-center gap-3 cursor-pointer hover:scale-105 transition-all">
        <svg class="w-5 h-5 text-[var(--theme-primary)] animate-pulse" fill="none" stroke="currentColor"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div class="flex flex-col">
            <span
                class="text-[10px] font-bold tracking-widest uppercase text-[var(--theme-primary)] leading-none mb-1">Pending</span>
            <span class="text-[11px] text-[#110A08] font-mono font-bold leading-none tracking-tight">#<span
                    id="minimized-order-number"></span></span>
        </div>
    </div>

    <div id="order-wa-followup"
        class="hidden fixed left-1/2 -translate-x-1/2 bottom-24 w-[92%] max-w-md z-[1600] flex-col gap-3 p-4 rounded-2xl bg-white border border-[var(--theme-primary)]/25 shadow-[0_12px_40px_rgba(0,0,0,0.15)]">
        <p class="text-[12px] text-[#110A08] font-medium text-center leading-snug">
            Order received. Tap below to open WhatsApp and send the message to the store (works reliably on iPhone).
        </p>
        <a id="order-wa-followup-link" href="#" target="_blank" rel="noopener noreferrer"
            class="w-full bg-[#25D366] hover:bg-[#20BA5A] text-white py-3.5 rounded-xl font-bold text-[12px] tracking-wide flex justify-center items-center gap-2 transition-colors">
            <svg class="h-6 w-6 shrink-0 text-white" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                <path fill="currentColor"
                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.123 1.035 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.435 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
            </svg>
            <span>Open WhatsApp</span>
        </a>
        <button type="button" onclick="App.dismissOrderWaFollowup()"
            class="text-[10px] font-bold text-[#A3B8C9] uppercase tracking-wider hover:text-[#110A08]">Dismiss</button>
    </div>

    <script>
        window.TENANT_STORE_NAME = "{{ $tenant->name ?? 'Söya Menzah9' }}";
        window.TENANT_WA_NUMBER = "{{ $tenant->whatsapp_number ?? '216557786656' }}";
        window.ALL_PRODUCTS = @json($categories->flatMap->products);

        const openProductModal = (id) => App.openModal(id);
        const closeModal = () => App.close();
        const confirmProduct = () => App.confirm();

        function toggleOrderTracker(showExpanded) {
            const overlay = document.getElementById('order-tracker-overlay');
            const expanded = document.getElementById('order-tracker-expanded');
            const minimized = document.getElementById('order-tracker-minimized');

            if (showExpanded) {
                minimized.classList.add('hidden');
                minimized.classList.remove('flex');
                overlay.classList.remove('hidden');
                overlay.classList.add('flex');
                setTimeout(() => {
                    expanded.classList.remove('scale-95', 'opacity-0');
                    expanded.classList.add('scale-100', 'opacity-100');
                }, 10);
            } else {
                expanded.classList.remove('scale-100', 'opacity-100');
                expanded.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    overlay.classList.add('hidden');
                    overlay.classList.remove('flex');
                    minimized.classList.remove('hidden');
                    minimized.classList.add('flex');
                }, 300);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const sections = document.querySelectorAll('.section-spy');
            const navLinks = document.querySelectorAll('.nav-link');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        navLinks.forEach(link => link.classList.remove('active-nav'));
                        const activeLink = document.querySelector(
                            `.nav-link[href="#${entry.target.id}"]`);
                        if (activeLink) {
                            activeLink.classList.add('active-nav');
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
