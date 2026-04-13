<div id="checkout-modal" class="fixed inset-0 bg-[#2c3034]/70 backdrop-blur-[4px] z-[2000] hidden flex-col justify-end">
    <div id="checkout-sheet"
        class="bg-[#eaedf0] w-full max-w-lg mx-auto rounded-t-[2rem] shadow-[0_-15px_40px_rgba(0,0,0,0.2)] flex flex-col relative transition-transform duration-300 translate-y-full max-h-[92vh]">

        <div class="w-12 h-1.5 bg-[#cbd2d9] rounded-full mx-auto mt-4 mb-2"></div>

        <div class="absolute top-5 right-5 z-20">
            <button onclick="App.closeCheckout()"
                class="w-8 h-8 flex items-center justify-center rounded-full bg-white/50 text-[#8b949e] hover:bg-white hover:text-[#2c3034] transition-colors shadow-sm">✕</button>
        </div>

        <div class="overflow-y-auto px-4 pt-4 pb-32">

                <div id="checkout-soy-character"
                    class="hidden absolute top-0 right-12 flex-col items-center pointer-events-none z-30">
                    <div
                        class="bg-[var(--theme-primary)] text-white text-[10px] font-bold py-1.5 px-4 rounded-full mb-1 shadow-lg whitespace-nowrap animate-bounce">
                        Tell me your name!
                    </div>
                    <svg width="40" height="60" viewBox="0 0 60 90" class="drop-shadow-xl soy-shake">
                        <path d="M15,20 L45,20 L42,5 L18,5 Z" fill="#e60012" />
                        <path d="M18,20 L42,20 L50,80 C50,85 45,90 30,90 C15,90 10,85 10,80 L18,20 Z" fill="#2c1a16" />
                        <rect x="20" y="35" width="20" height="30" fill="white" rx="2" />
                        <circle cx="30" cy="50" r="5" fill="#e60012" />
                        <path d="M45,30 L55,20 M55,30 L45,20" stroke="#e60012" stroke-width="3"
                            stroke-linecap="round" />
                    </svg>
                </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm relative border border-[#d1d8e0]"
                style="background-image: radial-gradient(#eaedf0 1px, transparent 1px); background-size: 20px 20px; background-position: 0 0;">

                <div class="text-center mb-6">
                    {{-- 店舗名を変数化 --}}
                    <h2 class="serif text-2xl font-bold text-[#2c3034]">{{ $tenant->name ?? 'Store' }}<span
                            class="text-[var(--theme-primary)]">.</span></h2>
                    <p class="font-mono text-[9px] text-[#8b949e] uppercase tracking-widest mt-1">Order Slip <span
                            class="mx-1">|</span> <span id="receipt-date"></span></p>
                    <div class="border-b-2 border-dashed border-[#eaedf0] mt-5"></div>
                </div>

                <div id="checkout-items" class="font-mono text-sm text-[#2c3034] space-y-4 mb-6 min-h-[80px]">
                </div>

                <div class="border-b-2 border-dashed border-[#eaedf0] mb-6"></div>

                <div class="space-y-5 font-sans">
                    <div>
                        <label class="block text-[10px] font-bold tracking-widest text-[#8b949e] uppercase mb-2">Guest
                            Name <span class="text-[var(--theme-primary)]">*</span></label>
                        <input type="text" id="order-name"
                            class="w-full bg-[#f8f9fa] border border-[#d1d8e0] rounded-xl px-4 py-3.5 text-sm focus:outline-none focus:border-[var(--theme-primary)] focus:bg-white transition-all font-bold text-[#2c3034]"
                            placeholder="Your Name">
                    </div>

                    <div>
                        <label
                            class="block text-[10px] font-bold tracking-widest text-[#8b949e] uppercase mb-2">WhatsApp
                            Number <span class="text-[var(--theme-primary)]">*</span></label>
                        <input type="tel" id="order-phone"
                            class="w-full bg-[#f8f9fa] border border-[#d1d8e0] rounded-xl px-4 py-3.5 text-sm font-mono focus:outline-none focus:border-[var(--theme-primary)] focus:bg-white transition-all font-bold text-[#2c3034]"
                            placeholder="+216 ...">
                    </div>
                </div>
            </div>
        </div>

        <div
            class="absolute bottom-0 left-0 right-0 p-5 bg-white border-t border-[#eaedf0] rounded-t-3xl shadow-[0_-5px_20px_rgba(0,0,0,0.05)] z-40">
            <div class="flex justify-between items-end mb-4 px-2">
                <span class="text-[10px] font-bold tracking-widest uppercase text-[#8b949e]">Total Due</span>
                <span class="font-mono font-bold text-3xl text-[#2c3034] leading-none"><span
                        id="checkout-total">0.000</span> <span class="text-sm font-sans text-[#8b949e]">DT</span></span>
            </div>
            {{-- WhatsApp ブランド（テナントテーマ色とは独立） --}}
            <button id="submit-order-btn" type="button" onclick="App.submitOrder()"
                class="group w-full bg-[#25D366] hover:bg-[#20BA5A] active:bg-[#1DA851] text-white py-4 px-4 rounded-2xl font-bold text-[13px] tracking-wide transition-colors shadow-lg shadow-[#25D366]/35 hover:shadow-[#25D366]/45 flex justify-center items-center gap-3">
                <svg class="h-7 w-7 shrink-0 text-white" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                    <path fill="currentColor"
                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.123 1.035 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.435 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                </svg>
                <span>Commander sur WhatsApp</span>
            </button>
        </div>
    </div>
</div>
