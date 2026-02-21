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
                    class="bg-[#e60012] text-white text-[10px] font-bold py-1.5 px-4 rounded-full mb-1 shadow-lg whitespace-nowrap animate-bounce">
                    Tell me your name!
                </div>
                <svg width="40" height="60" viewBox="0 0 60 90" class="drop-shadow-xl soy-shake">
                    <path d="M15,20 L45,20 L42,5 L18,5 Z" fill="#e60012" />
                    <path d="M18,20 L42,20 L50,80 C50,85 45,90 30,90 C15,90 10,85 10,80 L18,20 Z" fill="#2c1a16" />
                    <rect x="20" y="35" width="20" height="30" fill="white" rx="2" />
                    <circle cx="30" cy="50" r="5" fill="#e60012" />
                    <path d="M45,30 L55,20 M55,30 L45,20" stroke="#e60012" stroke-width="3" stroke-linecap="round" />
                </svg>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm relative border border-[#d1d8e0]"
                style="background-image: radial-gradient(#eaedf0 1px, transparent 1px); background-size: 20px 20px; background-position: 0 0;">

                <div class="text-center mb-6">
                    <h2 class="serif text-2xl font-bold text-[#2c3034]">Söya.</h2>
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
                            Name <span class="text-[#e60012]">*</span></label>
                        <input type="text" id="order-name"
                            class="w-full bg-[#f8f9fa] border border-[#d1d8e0] rounded-xl px-4 py-3.5 text-sm focus:outline-none focus:border-[#e60012] focus:bg-white transition-all font-bold text-[#2c3034]"
                            placeholder="Your Name">
                    </div>

                    <div>
                        <label
                            class="block text-[10px] font-bold tracking-widest text-[#8b949e] uppercase mb-2">WhatsApp
                            Number <span class="text-[#e60012]">*</span></label>
                        <input type="tel" id="order-phone"
                            class="w-full bg-[#f8f9fa] border border-[#d1d8e0] rounded-xl px-4 py-3.5 text-sm font-mono focus:outline-none focus:border-[#e60012] focus:bg-white transition-all font-bold text-[#2c3034]"
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
            <button id="submit-order-btn" onclick="App.submitOrder()"
                class="w-full bg-[#e60012] text-white py-4 rounded-2xl font-bold tracking-[0.15em] text-[12px] hover:bg-[#cc0010] transition-colors shadow-[0_8px_20px_rgba(230,0,18,0.3)] flex justify-center items-center gap-2">
                SEND TO KITCHEN
            </button>
        </div>
    </div>
</div>
