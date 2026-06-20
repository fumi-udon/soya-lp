<script src="https://cdn.tailwindcss.com"></script>
<style>
    html.soya-app-html,
    body.soya-app-body {
        height: 100%;
        margin: 0;
        overflow: hidden;
        overscroll-behavior: none;
        -webkit-text-size-adjust: 100%;
    }

    body.soya-app-body,
    body.soya-app-body .concrete-bg {
        background-color: #eaedf0 !important;
    }

    body.soya-app-body .global-header,
    body.soya-app-body .global-nav,
    body.soya-app-body .site-footer {
        display: none !important;
    }

    .soya-app-shell {
        display: flex;
        flex-direction: column;
        width: 100%;
        max-width: 480px;
        height: 100dvh;
        height: 100svh;
        max-height: 100dvh;
        max-height: 100svh;
        margin: 0 auto;
        overflow: hidden;
        background-color: #eaedf0;
        color: #110A08;
    }

    .soya-app-header {
        flex: 0 0 auto;
    }

    .soya-app-main {
        display: flex;
        flex-direction: column;
        flex: 1 1 0;
        min-height: 0;
        overflow: hidden;
    }

    .soya-app-scroll {
        flex: 1 1 0;
        min-height: 0;
        overflow-x: hidden;
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
        overscroll-behavior-y: contain;
        touch-action: pan-y;
        padding: 1rem 1rem 0.5rem;
    }

    .soya-app-actions {
        flex: 0 0 auto;
        padding: 0.5rem 1rem max(0.75rem, env(safe-area-inset-bottom));
        background: #eaedf0;
        border-top: 1px solid rgba(163, 184, 201, 0.3);
        box-shadow: 0 -4px 16px rgba(17, 10, 8, 0.06);
    }

    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .mobile-menu-root {
        pointer-events: none;
        visibility: hidden;
    }
    .mobile-menu-root.is-open {
        pointer-events: auto;
        visibility: visible;
    }
    .mobile-menu-overlay {
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .mobile-menu-root.is-open .mobile-menu-overlay {
        opacity: 1;
    }
    .mobile-menu-panel {
        transform: translateX(100%);
        transition: transform 0.35s cubic-bezier(0.32, 0.72, 0, 1);
    }
    .mobile-menu-root.is-open .mobile-menu-panel {
        transform: translateX(0);
    }
    .mobile-menu-trigger {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 4px;
        width: 2.25rem;
        height: 2.25rem;
        border-radius: 0.65rem;
        background: rgba(163, 184, 201, 0.2);
        border: none;
        cursor: pointer;
        transition: background 0.2s ease;
    }
    .mobile-menu-trigger:active {
        background: rgba(163, 184, 201, 0.35);
    }
    .mobile-menu-trigger span {
        display: block;
        width: 14px;
        height: 1.5px;
        background: #110A08;
        border-radius: 1px;
        transition: transform 0.25s ease, opacity 0.25s ease;
    }
    .mobile-menu-trigger.is-open span:nth-child(1) {
        transform: translateY(5.5px) rotate(45deg);
    }
    .mobile-menu-trigger.is-open span:nth-child(2) {
        opacity: 0;
    }
    .mobile-menu-trigger.is-open span:nth-child(3) {
        transform: translateY(-5.5px) rotate(-45deg);
    }
    .mobile-menu-link {
        display: flex;
        align-items: center;
        gap: 0.875rem;
        padding: 0.75rem;
        border-radius: 1rem;
        text-decoration: none;
        color: inherit;
        transition: background 0.2s ease, transform 0.15s ease;
    }
    .mobile-menu-link:active {
        transform: scale(0.98);
    }
    .mobile-menu-link:hover {
        background: rgba(163, 184, 201, 0.12);
    }
    .mobile-menu-link--accent {
        background: #110A08;
    }
    .mobile-menu-link--accent:hover {
        background: #1a100d;
    }
    .mobile-menu-icon {
        flex-shrink: 0;
        width: 2.75rem;
        height: 2.75rem;
        border-radius: 0.85rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(163, 184, 201, 0.18);
    }

    .soya-input {
        width: 100%;
        border: none;
        border-bottom: 1px solid rgba(163, 184, 201, 0.45);
        background: transparent;
        padding: 0.75rem 0;
        font-size: 0.9rem;
        letter-spacing: 0.06em;
        color: #110A08;
        outline: none;
    }
    .soya-input:focus {
        border-bottom-color: #110A08;
    }
    .soya-label {
        font-size: 0.55rem;
        font-weight: 700;
        letter-spacing: 0.22em;
        text-transform: uppercase;
        color: #A3B8C9;
        display: block;
        margin-bottom: 0.5rem;
    }
    .soya-btn-primary {
        width: 100%;
        padding: 0.8rem;
        border-radius: 0.85rem;
        border: none;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: #ffffff;
        background: #110A08;
        cursor: pointer;
        transition: transform 0.15s ease, background 0.2s ease;
    }
    .soya-btn-primary:active {
        transform: scale(0.98);
    }
    .soya-btn-secondary {
        width: 100%;
        padding: 0.8rem;
        border-radius: 0.85rem;
        border: 1px solid rgba(163, 184, 201, 0.45);
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: #110A08;
        background: transparent;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        display: block;
        transition: transform 0.15s ease;
    }
    .soya-recap-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.65rem 0.75rem;
    }
    .soya-recap-item--full {
        grid-column: 1 / -1;
    }
    .soya-recap-item dt {
        font-size: 0.5rem;
        font-weight: 700;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: #A3B8C9;
        margin-bottom: 0.2rem;
    }
    .soya-recap-item dd {
        font-size: 0.85rem;
        font-weight: 600;
        color: #110A08;
        margin: 0;
        line-height: 1.3;
    }
</style>
