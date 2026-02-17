<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu | Söya.</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;1,700&family=Montserrat:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    @vite(['resources/sass/menu.scss'])

    <style>
        /* 左上の常駐戻るボタン (SCSSで管理しているので、ここは削除可能ですが念のため残す場合は以下) */
        .nav-back-fixed {
            position: fixed;
            top: 16px;
            left: 16px;
            z-index: 1000;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
            opacity: 0.6;
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

<body class="pb-32">

    <a href="{{ url('/') }}" class="nav-back-fixed">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
            stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        <span class="nav-back-text">Söya.</span>
    </a>

    <div id="soy-rain-container"></div>

    <div
        class="sticky top-0 z-40 bg-white/95 backdrop-blur-md shadow-sm border-b border-gray-100 transition-all duration-300">
        <header class="pt-3 pb-1 px-4 text-center">
            <a href="{{ url('/') }}" class="inline-block hover:opacity-70 transition-opacity">
                <h1 class="serif text-xl font-bold tracking-tight text-[#1a1a1a]">Söya<span
                        class="text-[#e60012]">.</span></h1>
            </a>
        </header>
        <div class="flex gap-6 px-4 py-3 overflow-x-auto category-nav items-center">
            @foreach ($categories as $category)
                <a href="#cat-{{ $category->id }}"
                    class="nav-link whitespace-nowrap text-[10px] font-bold tracking-[0.15em] uppercase text-gray-400 transition-all duration-200"
                    data-target="cat-{{ $category->id }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </div>

    <main class="px-0 mt-2 max-w-xl mx-auto">
        @foreach ($categories as $category)
            <section id="cat-{{ $category->id }}" class="section-spy pt-6 pb-2">
                <div class="px-4 mb-2 flex items-center gap-2 sticky top-[100px] z-30 pointer-events-none">
                    <div class="bg-gray-100/90 backdrop-blur px-3 py-1 rounded-full border border-gray-200">
                        <h2 class="text-[10px] font-bold uppercase tracking-widest text-gray-900">{{ $category->name }}
                        </h2>
                    </div>
                </div>
                <div class="bg-white border-t border-b border-gray-100 divide-y divide-gray-100">
                    @foreach ($category->products as $product)
                        <div onclick="openProductModal({{ $product->id }})"
                            class="relative flex items-center gap-3 p-3 active:bg-gray-50 transition-colors cursor-pointer group h-[88px]">

                            <div
                                class="w-16 h-16 shrink-0 bg-gray-50 rounded-md overflow-hidden relative border border-gray-100">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div
                                        class="w-full h-full flex items-center justify-center text-[8px] text-gray-300">
                                        NO IMG</div>
                                @endif
                            </div>

                            <div class="flex-1 min-w-0 flex flex-col justify-center h-full py-1">
                                <h3 class="serif text-[15px] font-bold leading-tight text-gray-900 mb-1 truncate pr-2">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-[10px] text-gray-400 line-clamp-1 leading-tight mb-1">
                                    {!! strip_tags($product->description) !!}
                                </p>
                                @if ($product->productVariants->count() > 0)
                                    <span
                                        class="inline-flex items-center px-1.5 py-0.5 rounded-[4px] text-[8px] font-medium bg-gray-50 text-gray-500 border border-gray-100 self-start">
                                        {{ $product->productVariants->count() }} Styles
                                    </span>
                                @endif
                            </div>

                            <div class="flex flex-col justify-between items-end h-full py-1 pl-2 shrink-0">
                                <span class="font-bold text-[13px] text-gray-900">
                                    {{ number_format($product->price, 3) }}
                                    @if ($product->productVariants->where('is_required', true)->count() > 0)
                                        <span class="text-[9px] text-gray-400 font-normal">~</span>
                                    @endif
                                </span>
                                <button
                                    class="w-7 h-7 rounded-full bg-[#f4f5f7] text-[#1a1a1a] flex items-center justify-center shadow-sm group-hover:bg-[#1a1a1a] group-hover:text-white transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
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
        class="fixed bottom-6 left-4 right-4 bg-[#1a1a1a] text-white py-3 px-5 rounded-full flex justify-between items-center shadow-[0_10px_40px_rgba(0,0,0,0.4)] z-[1000] hidden animate-[fadeInUp_0.3s_ease-out]">
        <div class="flex flex-col">
            <span class="text-[8px] tracking-widest text-gray-400 uppercase">Total</span>
            <div class="font-bold text-base leading-none">
                <span id="cart-total">0.000</span> <span class="text-[10px] font-normal">DT</span>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <div class="bg-gray-800 px-3 py-1 rounded-full text-[10px] font-medium text-gray-300">
                <span id="cart-count">0</span> items
            </div>
            <button onclick="alert('Order function coming soon!')"
                class="bg-white text-black px-5 py-2 rounded-full text-[10px] font-bold tracking-widest uppercase hover:bg-gray-200 transition">
                Check Out
            </button>
        </div>
    </div>

    <div id="product-modal"
        class="fixed inset-0 bg-black/60 backdrop-blur-[3px] z-[2000] hidden items-end justify-center sm:items-center">
        <div
            class="bg-white w-full max-w-lg rounded-t-[2rem] sm:rounded-3xl overflow-hidden shadow-2xl max-h-[92vh] flex flex-col relative">

            <div class="p-6 pb-2 shrink-0 relative z-10 bg-white">
                <button onclick="closeModal()"
                    class="absolute top-5 right-5 w-8 h-8 flex items-center justify-center rounded-full bg-gray-50 text-gray-400 hover:bg-gray-100 transition-colors">✕</button>
                <h2 id="modal-product-name" class="serif text-2xl font-bold pr-10 leading-none mb-2"></h2>
                <div class="mt-3 space-y-2">
                    <p id="modal-description" class="text-xs text-gray-500 leading-relaxed font-medium"></p>
                    <p id="modal-ingredients"
                        class="text-[9px] text-gray-400 uppercase tracking-wider border-l-2 border-[#e60012] pl-2"></p>
                </div>
            </div>

            <div id="modal-options" class="p-6 pt-2 overflow-y-auto grow bg-white"></div>

            <div class="p-5 pt-0 border-t border-gray-50 shrink-0 bg-white relative z-20">

                <div id="soy-character"
                    class="hidden absolute -top-20 left-1/2 flex-col items-center pointer-events-none z-30"
                    style="transform: translateX(-50%);">
                    <div
                        class="bg-[#e60012] text-white text-[10px] font-bold py-1 px-3 rounded-full mb-2 shadow-lg whitespace-nowrap animate-bounce">
                        Please select a style.
                    </div>
                    <svg width="50" height="80" viewBox="0 0 60 90" class="drop-shadow-xl soy-shake">
                        <path d="M15,20 L45,20 L42,5 L18,5 Z" fill="#e60012" />
                        <path d="M18,20 L42,20 L50,80 C50,85 45,90 30,90 C15,90 10,85 10,80 L18,20 Z" fill="#2c1a16" />
                        <rect x="20" y="35" width="20" height="30" fill="white" rx="2" />
                        <circle cx="30" cy="50" r="5" fill="#e60012" />
                    </svg>
                </div>

                <button id="add-to-cart-btn" onclick="confirmProduct()"
                    class="w-full bg-[#1a1a1a] text-white py-4 rounded-xl font-bold tracking-[0.15em] text-xs hover:bg-[#e60012] transition-colors shadow-lg flex justify-center items-center gap-2">
                    ADD TO ORDER
                </button>
            </div>
        </div>
    </div>

    <script>
        window.ALL_PRODUCTS = @json($categories->flatMap->products);
        const openProductModal = (id) => App.openModal(id);
        const closeModal = () => App.close();
        const confirmProduct = () => App.confirm();

        // Soy Rain Logic
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
            soyRainContainer.appendChild(drop);
            setTimeout(() => {
                drop.remove();
            }, 1200);
        }

        // Scroll Spy Logic
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
        });
    </script>
    <script src="{{ asset('js/menu.js') }}"></script>
</body>

</html>
