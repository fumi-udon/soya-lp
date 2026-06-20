<footer class="site-footer">
    <div class="footer-container">
        <div class="insta-cta-wrapper">
            <a href="https://www.instagram.com/soya.tunis/" target="_blank" class="insta-btn">
                <span class="btn-icon">
                    <i class="bi bi-instagram"></i>
                </span>
                <span class="btn-label" id="footer-text">Follow us @soya.tunis</span>
            </a>
        </div>

        <address class="store-info-grid" style="font-style: normal;" itemscope itemtype="https://schema.org/Restaurant">
            <meta itemprop="name" content="Söya.">
            <meta itemprop="servesCuisine" content="Japanese, Ramen">
            <meta itemprop="url" content="https://soya.bistronippon.tn/">

            <div class="info-item" itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
                <span class="info-label">Address</span>
                <p class="info-value">
                    <a href="https://www.google.com/maps/search/?api=1&query=38%20Av.%20Salah%20Ben%20Youssef%2C%20Tunis%201013"
                       target="_blank" rel="noopener noreferrer"
                       style="color: inherit; text-decoration: none;">
                        <span itemprop="streetAddress">38 Av. Salah Ben Youssef</span>,
                        <span itemprop="addressLocality">Tunis</span>
                        <span itemprop="postalCode">1013</span><meta itemprop="addressCountry" content="TN">
                    </a>
                </p>
            </div>

            <div class="info-item">
                <span class="info-label">Tel &amp; Reservation</span>
                <p class="info-value">
                    <a href="tel:{{ config('services.soya.tel', '+21654497077') }}" itemprop="telephone" content="{{ config('services.soya.tel', '+21654497077') }}"
                       style="color: inherit; text-decoration: none;">{{ str_replace(' ', '&nbsp;', config('services.soya.tel_display', '54 497 077')) }}</a>
                    <span aria-hidden="true" style="opacity: 0.4; margin: 0 6px;">·</span>
                    <a href="{{ route('reservation') }}"
                       style="color: inherit; text-decoration: none;">Reservation</a>
                </p>
            </div>

            <div class="info-item">
                <span class="info-label">Email</span>
                <p class="info-value">
                    <a href="mailto:soya.menzah9@gmail.com" itemprop="email"
                       style="color: inherit; text-decoration: none;">soya.menzah9@gmail.com</a>
                </p>
            </div>
        </address>

        <div class="team-credit">
            <span class="credit-label">Produced by</span>
            <span class="credit-name">Bistro Nippon Team</span>
        </div>
    </div>
</footer>
