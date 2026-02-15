<header class="global-header">
    <div class="nav-left">
        <a href="{{ url('/') }}" class="logo-link">
            <img src="{{ asset('logo.svg') }}" alt="Söya." style="height: 32px;">
        </a>
    </div>

    <div class="nav-right">
        @env('local')
            <button class="menu-trigger" id="menuTrigger">
                <span class="bottle-wrapper">
                    <svg viewBox="0 0 100 150" xmlns="http://www.w3.org/2000/svg">

                        <path class="sauce-stream" d="M35,55 L35,140" stroke="#2c1a16" stroke-width="6"
                            stroke-linecap="round" fill="none" />
                        <circle class="sauce-drop" cx="35" cy="140" r="3" fill="#2c1a16" />

                        <g class="bottle-group">

                            <path class="bottle-liquid-bottom"
                                d="M22,110 L78,110 C78,122 68,130 50,130 C32,130 22,122 22,110 Z" fill="#2c1a16"
                                stroke="none" />

                            <path class="bottle-liquid-full"
                                d="M27,60 L73,60 L78,110 C78,122 68,130 50,130 C32,130 22,122 22,110 L27,60 Z"
                                fill="#2c1a16" stroke="none" opacity="0" />

                            <path class="bottle-body"
                                d="M25,50 L75,50 L80,110 C80,125 70,135 50,135 C30,135 20,125 20,110 L25,50 Z"
                                stroke="currentColor" stroke-width="3" fill="none" />

                            <path class="bottle-cap" d="M25,50 L75,50 L70,25 L30,25 L25,50 Z M20,30 L30,25 L30,35 Z"
                                stroke="currentColor" stroke-width="3" fill="#fff" />
                        </g>
                    </svg>
                </span>
            </button>
        @endenv
    </div>
</header>

<nav class="global-nav" id="globalNav">
    {{-- メニューの中身は変更なし --}}
    <ul class="nav-links">
        <li><a href="{{ url('/') }}" class="nav-item">Home</a></li>
        <li><a href="{{ url('/reservation') }}" class="nav-item">Reservation</a></li>
        <li><a href="https://www.instagram.com/soya.tunis/" target="_blank" class="nav-item">Instagram</a></li>
    </ul>
</nav>
