<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Söya. | prod. bistronippon')</title>

    @stack('meta')
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @include('parts.soya-app-styles')
    @stack('page-styles')
</head>

<body>
    <div class="concrete-bg"></div>

    <div class="flex flex-col w-full overflow-hidden mx-auto max-w-[480px] min-h-[100dvh]"
         style="background-color: #eaedf0; color: #110A08;">

        <header class="shrink-0 flex items-center justify-between px-5 py-3 border-b"
                style="background-color: #eaedf0; border-color: rgba(163,184,201,0.3);">
            <div>
                <a href="{{ url('/') }}" style="text-decoration: none; color: inherit;">
                    <h1 style="font-family: 'Playfair Display', serif; font-size: 1.3rem;
                               font-weight: 700; letter-spacing: -0.02em; color: #110A08;">
                        SÖYA.
                    </h1>
                    <p style="font-size: 0.6rem; letter-spacing: 0.2em;
                              color: #A3B8C9; margin-top: 1px;">
                        北 と 北
                    </p>
                </a>
            </div>
            <button type="button"
                    id="mobile-menu-trigger"
                    class="mobile-menu-trigger"
                    aria-expanded="false"
                    aria-controls="mobile-menu-root"
                    aria-label="Ouvrir le menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </header>

        <main class="flex-1 overflow-y-auto overscroll-contain hide-scrollbar px-4 py-5"
              style="-webkit-overflow-scrolling: touch;">
            @yield('content')
        </main>
    </div>

    @include('parts.soya-mobile-menu', ['reservationActive' => true])

    @stack('scripts')
    <script>
        const mobileMenuRoot = document.getElementById('mobile-menu-root');
        const mobileMenuTrigger = document.getElementById('mobile-menu-trigger');

        window.openMobileMenu = function() {
            if (!mobileMenuRoot) return;
            mobileMenuRoot.classList.add('is-open');
            mobileMenuRoot.setAttribute('aria-hidden', 'false');
            mobileMenuTrigger?.classList.add('is-open');
            mobileMenuTrigger?.setAttribute('aria-expanded', 'true');
            document.body.style.overflow = 'hidden';
        };

        window.closeMobileMenu = function() {
            if (!mobileMenuRoot) return;
            mobileMenuRoot.classList.remove('is-open');
            mobileMenuRoot.setAttribute('aria-hidden', 'true');
            mobileMenuTrigger?.classList.remove('is-open');
            mobileMenuTrigger?.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
        };

        mobileMenuTrigger?.addEventListener('click', () => {
            if (mobileMenuRoot?.classList.contains('is-open')) {
                closeMobileMenu();
            } else {
                openMobileMenu();
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && mobileMenuRoot?.classList.contains('is-open')) {
                closeMobileMenu();
            }
        });
    </script>
</body>

</html>
