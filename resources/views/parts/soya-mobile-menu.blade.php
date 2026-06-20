@php
    $menuUrl = 'https://soyam9.bistronippon.tn/guest/menu/soya/readonly';
    $reservationUrl = route('reservation');
    $homeUrl = url('/');
    $infoUrl = url('/#info-section');
    $infoInstagramUrl = 'https://www.instagram.com/soya.tunis/';
    $accessTel = config('services.soya.tel', '+21654497077');
    $accessTelHref = 'tel:'.preg_replace('/[^\d+]/', '', $accessTel);
    $accessTelDisplay = config('services.soya.tel_display', '54 497 077');
    $reservationActive = $reservationActive ?? false;
@endphp

<div id="mobile-menu-root"
     class="mobile-menu-root fixed inset-0 z-[70]"
     aria-hidden="true"
     role="dialog"
     aria-labelledby="mobile-menu-title">
    <div class="mobile-menu-overlay absolute inset-0 bg-black/30"
         onclick="closeMobileMenu()"
         aria-hidden="true"></div>

    <div id="mobile-menu-panel"
         class="mobile-menu-panel absolute inset-y-0 right-0 left-0 mx-auto max-w-[480px] overflow-y-auto overscroll-contain hide-scrollbar"
         style="background: #eaedf0;"
         onclick="event.stopPropagation()">
        <div class="flex flex-col min-h-full px-5 pt-5 pb-8">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <p style="font-family: 'Playfair Display', serif; font-size: 0.85rem;
                              font-weight: 700; letter-spacing: 0.08em; color: #A3B8C9;">
                        SÖYA.
                    </p>
                    <h2 id="mobile-menu-title"
                        style="font-size: 1.75rem; font-weight: 700; color: #110A08; margin-top: 0.35rem; line-height: 1.1;">
                        Menu
                    </h2>
                </div>
                <button type="button"
                        onclick="closeMobileMenu()"
                        class="flex items-center justify-center w-9 h-9 rounded-xl active:scale-95 transition-transform"
                        style="background: rgba(163,184,201,0.2);"
                        aria-label="Fermer le menu">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                         fill="none" stroke="#110A08" stroke-width="2" stroke-linecap="round">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>

            <nav class="flex flex-col gap-1">
                <a href="{{ $homeUrl }}" class="mobile-menu-link">
                    <span class="mobile-menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                             fill="none" stroke="#110A08" stroke-width="1.5" stroke-linecap="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                            <polyline points="9 22 9 12 15 12 15 22"/>
                        </svg>
                    </span>
                    <span>
                        <span class="block text-sm font-bold" style="color: #110A08;">Accueil</span>
                        <span class="block text-xs mt-0.5" style="color: #A3B8C9;">Découvrir Söya</span>
                    </span>
                </a>

                <a href="{{ $menuUrl }}" class="mobile-menu-link">
                    <span class="mobile-menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                             fill="none" stroke="#110A08" stroke-width="1.5" stroke-linecap="round">
                            <rect x="3" y="3" width="18" height="4" rx="1"/>
                            <rect x="3" y="9" width="18" height="4" rx="1"/>
                            <rect x="3" y="15" width="18" height="4" rx="1"/>
                        </svg>
                    </span>
                    <span>
                        <span class="block text-sm font-bold" style="color: #110A08;">Menu</span>
                        <span class="block text-xs mt-0.5" style="color: #A3B8C9;">Carte &amp; spécialités</span>
                    </span>
                </a>

                <a href="{{ $reservationUrl }}"
                   @class(['mobile-menu-link', 'mobile-menu-link--accent' => $reservationActive])>
                    <span class="mobile-menu-icon" @if($reservationActive) style="background: rgba(255,255,255,0.12);" @endif>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                             fill="none" stroke="{{ $reservationActive ? '#ffffff' : '#110A08' }}" stroke-width="1.5" stroke-linecap="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                    </span>
                    <span>
                        <span class="block text-sm font-bold" style="color: {{ $reservationActive ? '#ffffff' : '#110A08' }};">Réservation</span>
                        <span class="block text-xs mt-0.5" style="color: {{ $reservationActive ? 'rgba(255,255,255,0.65)' : '#A3B8C9' }};">Réserver une table</span>
                    </span>
                </a>

                <a href="{{ $infoUrl }}" class="mobile-menu-link">
                    <span class="mobile-menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                             fill="none" stroke="#110A08" stroke-width="1.5" stroke-linecap="round">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="8" x2="12" y2="12"/>
                            <line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                    </span>
                    <span>
                        <span class="block text-sm font-bold" style="color: #110A08;">Infos</span>
                        <span class="block text-xs mt-0.5" style="color: #A3B8C9;">Horaires &amp; accès</span>
                    </span>
                </a>

                <a href="{{ $infoInstagramUrl }}"
                   target="_blank" rel="noopener noreferrer"
                   class="mobile-menu-link">
                    <span class="mobile-menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                             fill="none" stroke="#110A08" stroke-width="1.5" stroke-linecap="round">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                            <circle cx="12" cy="12" r="4"/>
                            <circle cx="17.5" cy="6.5" r="1" fill="#110A08" stroke="none"/>
                        </svg>
                    </span>
                    <span>
                        <span class="block text-sm font-bold" style="color: #110A08;">Instagram</span>
                        <span class="block text-xs mt-0.5" style="color: #A3B8C9;">@soya.tunis</span>
                    </span>
                </a>

                <a href="{{ $accessTelHref }}" class="mobile-menu-link">
                    <span class="mobile-menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                             fill="none" stroke="#110A08" stroke-width="1.8" stroke-linecap="round">
                            <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.8 19.79 19.79 0 01.15 1.19 2 2 0 012.11 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92v2z"/>
                        </svg>
                    </span>
                    <span>
                        <span class="block text-sm font-bold" style="color: #110A08;">Téléphone</span>
                        <span class="block text-xs mt-0.5" style="color: #A3B8C9;">{{ $accessTelDisplay }}</span>
                    </span>
                </a>
            </nav>
        </div>
    </div>
</div>
