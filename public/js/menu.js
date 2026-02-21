/**
 * Söya. Modern Menu Logic (Full Version)
 */
window.App = {
    state: {
        cart: [],
        currentProduct: null,
        selectedType: null,
        selectedExtras: []
    },

    // ==========================================
    // 1. PRODUCT MODAL LOGIC (商品選択)
    // ==========================================
    openModal(productId) {
        const product = window.ALL_PRODUCTS.find(p => p.id === productId);
        if (!product) return;

        this.state.currentProduct = product;
        this.state.selectedType = null;
        this.state.selectedExtras = [];

        // ギミックリセット
        const chara = document.getElementById('soy-character');
        if (chara) {
            chara.classList.remove('soy-appear');
            const msgBox = chara.querySelector('div');
            if (msgBox) msgBox.innerText = "Please select a style.";
        }

        const btn = document.getElementById('add-to-cart-btn');
        if (btn) btn.innerHTML = `ADD TO ORDER`;

        document.getElementById('modal-product-name').innerText = product.name;
        document.getElementById('modal-description').innerHTML = product.description ? product.description : '';
        const ingEl = document.getElementById('modal-ingredients');
        if (ingEl) {
            ingEl.innerText = product.ingredients ? `Contains: ${product.ingredients}` : '';
            ingEl.style.display = product.ingredients ? 'block' : 'none';
        }

        const types = product.product_variants.filter(v => v.is_required);
        const extras = product.product_variants.filter(v => !v.is_required);
        const container = document.getElementById('modal-options');
        if (container) container.innerHTML = '';

        // STYLE (必須)
        if (types.length > 0 && container) {
            const typeSection = document.createElement('div');
            typeSection.className = "mb-8";
            typeSection.innerHTML = `
                <p id="style-label" class="text-[10px] font-bold tracking-[0.2em] uppercase text-gray-400 mb-4 transition-all required-pulse">
                    Select Style <span class="text-[#e60012]">*</span>
                </p>`;

            const grid = document.createElement('div');
            grid.className = "flex flex-col gap-3";

            types.forEach(variant => {
                const btnEl = document.createElement('div');
                btnEl.className = "type-option relative overflow-hidden flex justify-between items-center p-4 rounded-xl border border-gray-100 bg-white shadow-sm cursor-pointer transition-all hover:border-gray-300";
                btnEl.dataset.id = variant.id;

                btnEl.innerHTML = `
                    <div class="flex items-center gap-4">
                        <div class="icon-slot w-5 h-5 rounded-full border border-gray-200 flex items-center justify-center bg-gray-50"></div>
                        <span class="text-sm font-bold text-gray-700">${variant.name}</span>
                    </div>
                    <span class="text-xs font-medium text-gray-500 bg-gray-50 px-2 py-1 rounded-md">${parseFloat(variant.price_adjustment).toFixed(3)} DT</span>
                `;
                btnEl.onclick = () => this.selectType(variant, btnEl);
                grid.appendChild(btnEl);
            });
            typeSection.appendChild(grid);
            container.appendChild(typeSection);
        }

        // TOPPINGS (任意)
        if (extras.length > 0 && container) {
            const extraSection = document.createElement('div');
            extraSection.className = "mb-4";
            extraSection.innerHTML = `<p class="text-[9px] font-bold tracking-[0.2em] uppercase text-gray-400 mb-4">Toppings</p>`;

            extras.forEach(variant => {
                const row = document.createElement('div');
                row.className = "extra-option flex justify-between items-center py-4 border-b border-gray-100 cursor-pointer group";
                row.innerHTML = `
                    <div class="flex items-center gap-3">
                        <div class="checkbox w-5 h-5 rounded border border-gray-300 flex items-center justify-center text-white transition-all group-hover:border-[#e60012]"></div>
                        <span class="text-sm text-gray-600 group-hover:text-black transition-colors">${variant.name}</span>
                    </div>
                    <span class="text-xs text-gray-400 font-medium">+${parseFloat(variant.price_adjustment).toFixed(3)}</span>
                `;
                row.onclick = () => this.toggleExtra(variant, row);
                extraSection.appendChild(row);
            });
            container.appendChild(extraSection);
        }

        this.updateTotal();

        const modal = document.getElementById('product-modal');
        if (modal) {
            modal.classList.remove('hidden');
            setTimeout(() => { modal.classList.add('active'); }, 10);
        }
    },

    selectType(variant, element) {
        this.state.selectedType = variant;

        const chara = document.getElementById('soy-character');
        if (chara) chara.classList.remove('soy-appear');

        const styleLabel = document.getElementById('style-label');
        if (styleLabel) {
            styleLabel.classList.remove('required-pulse');
            styleLabel.classList.add('text-gray-900');
        }

        document.querySelectorAll('.type-option').forEach(el => {
            el.className = "type-option relative overflow-hidden flex justify-between items-center p-4 rounded-xl border border-gray-100 bg-white shadow-sm cursor-pointer transition-all hover:border-gray-300";
            const iconSlot = el.querySelector('.icon-slot');
            if (iconSlot) {
                iconSlot.innerHTML = '';
                iconSlot.className = "icon-slot w-5 h-5 rounded-full border border-gray-200 flex items-center justify-center bg-gray-50";
            }
        });

        element.className = "type-option relative overflow-hidden flex justify-between items-center p-4 rounded-xl border-2 border-[#1a1a1a] bg-white shadow-lg cursor-pointer transform scale-[1.01] transition-all";

        const iconSlot = element.querySelector('.icon-slot');
        if (iconSlot) {
            iconSlot.className = "icon-slot w-5 h-5 flex items-center justify-center";
            iconSlot.innerHTML = `
                <svg viewBox="0 0 24 24" class="w-5 h-5 text-[#e60012] animate-roll">
                    <path fill="currentColor" d="M12,2 C17.52,2 22,6.48 22,12 C22,17.52 17.52,22 12,22 C6.48,22 2,17.52 2,12 C2,6.48 6.48,2 12,2 Z M12,6 L12,18 M6,12 L18,12" />
                </svg>
            `;
        }

        this.updateTotal();
    },

    toggleExtra(variant, element) {
        const index = this.state.selectedExtras.findIndex(v => v.id === variant.id);
        const checkbox = element.querySelector('.checkbox');

        if (index > -1) {
            this.state.selectedExtras.splice(index, 1);
            if (checkbox) {
                checkbox.classList.remove('bg-[#e60012]', 'border-[#e60012]');
                checkbox.innerHTML = '';
            }
        } else {
            this.state.selectedExtras.push(variant);
            if (checkbox) {
                checkbox.classList.add('bg-[#e60012]', 'border-[#e60012]');
                checkbox.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>';
            }
        }
        this.updateTotal();
    },

    updateTotal() {
        let total = 0;
        if (this.state.selectedType) {
            total = parseFloat(this.state.selectedType.price_adjustment);
        } else {
            total = parseFloat(this.state.currentProduct.price || 0);
        }
        this.state.selectedExtras.forEach(v => total += parseFloat(v.price_adjustment));

        const btn = document.getElementById('add-to-cart-btn');
        if (btn) btn.innerHTML = `ADD TO ORDER — <span class="ml-1">${total.toFixed(3)} DT</span>`;
    },

    confirm() {
        if (!this.state.currentProduct) return;
        const hasTypes = this.state.currentProduct.product_variants.some(v => v.is_required);

        if (hasTypes && !this.state.selectedType) {
            const chara = document.getElementById('soy-character');
            if (chara) {
                chara.classList.remove('soy-appear');
                void chara.offsetWidth; // リフロー
                chara.classList.add('soy-appear');
            }
            return;
        }

        let finalName = this.state.currentProduct.name;
        if (this.state.selectedType) {
            finalName += ` (${this.state.selectedType.name})`;
        }

        let finalPrice = 0;
        if (this.state.selectedType) {
            finalPrice = parseFloat(this.state.selectedType.price_adjustment);
        } else {
            finalPrice = parseFloat(this.state.currentProduct.price || 0);
        }
        this.state.selectedExtras.forEach(v => finalPrice += parseFloat(v.price_adjustment));

        this.state.cart.push({
            id: Date.now(),
            productId: this.state.currentProduct.id,
            name: finalName,
            price: finalPrice,
            variants: [...this.state.selectedExtras]
        });

        this.updateCartBar();
        this.close();
    },

    updateCartBar() {
        const bar = document.getElementById('cart-bar');
        if (!bar) return;

        const total = this.state.cart.reduce((sum, item) => sum + item.price, 0);
        const countEl = document.getElementById('cart-count');
        const totalEl = document.getElementById('cart-total');

        if (countEl) countEl.innerText = this.state.cart.length;
        if (totalEl) totalEl.innerText = total.toFixed(3);

        if (this.state.cart.length > 0) {
            bar.classList.remove('hidden');
        } else {
            bar.classList.add('hidden');
        }
    },

    close() {
        const modal = document.getElementById('product-modal');
        if (!modal) return;
        modal.classList.remove('active');
        setTimeout(() => { modal.classList.add('hidden'); }, 300);
    },

    // ==========================================
    // 2. CHECKOUT LOGIC (決済・送信・トラッカー)
    // ==========================================
    openCheckout() {
        if (this.state.cart.length === 0) return;

        const now = new Date();
        const dateEl = document.getElementById('receipt-date');
        if (dateEl) {
            dateEl.innerText = now.toLocaleString('en-GB', { month: 'short', day: 'numeric', hour: '2-digit', minute:'2-digit' });
        }

        this.renderCheckoutItems();

        const modal = document.getElementById('checkout-modal');
        const sheet = document.getElementById('checkout-sheet');

        if (modal && sheet) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            setTimeout(() => {
                sheet.classList.remove('translate-y-full');
                sheet.classList.add('translate-y-0');
            }, 10);
        }
    },

    closeCheckout() {
        const modal = document.getElementById('checkout-modal');
        const sheet = document.getElementById('checkout-sheet');

        if (modal && sheet) {
            sheet.classList.remove('translate-y-0');
            sheet.classList.add('translate-y-full');

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }
    },

    renderCheckoutItems() {
        const container = document.getElementById('checkout-items');
        if (!container) return;

        container.innerHTML = '';
        let total = 0;

        this.state.cart.forEach((item, index) => {
            total += item.price;
            let extraNames = item.variants.map(v => v.name).join(', ');
            let extraHtml = extraNames ? `<div class="text-[10px] text-gray-500 mt-1 pl-3 font-sans">+ ${extraNames}</div>` : '';

            const row = document.createElement('div');
            row.className = "flex justify-between items-start group";
            row.innerHTML = `
                <div class="flex-1 pr-4">
                    <div class="flex items-center gap-2">
                        <button onclick="App.removeItem(${index})" class="text-gray-300 hover:text-[#e60012] transition-colors"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"></path></svg></button>
                        <span class="font-bold">${item.name}</span>
                    </div>
                    ${extraHtml}
                </div>
                <span class="font-bold">${item.price.toFixed(3)}</span>
            `;
            container.appendChild(row);
        });

        const totalEl = document.getElementById('checkout-total');
        if (totalEl) totalEl.innerText = total.toFixed(3);
    },

    removeItem(index) {
        this.state.cart.splice(index, 1);
        this.updateCartBar();

        if (this.state.cart.length === 0) {
            this.closeCheckout();
        } else {
            this.renderCheckoutItems();
        }
    },

    async submitOrder() {
        const nameInput = document.getElementById('order-name');
        const phoneInput = document.getElementById('order-phone');
        const name = nameInput ? nameInput.value.trim() : '';
        const phone = phoneInput ? phoneInput.value.trim() : '';
        const typeEl = document.querySelector('input[name="order_type"]:checked');
        const type = typeEl ? typeEl.value : 'Takeaway';
        const notesInput = document.getElementById('order-notes');
        const notes = notesInput ? notesInput.value.trim() : '';

        // ギミック: 名前か電話番号がないとお叱り醤油ちゃん(店主モード)出現
        if (!name || !phone) {
            const chara = document.getElementById('checkout-soy-character');
            if (chara) {
                chara.classList.remove('hidden');
                chara.classList.remove('soy-appear');
                const msgBox = chara.querySelector('div');
                if (msgBox) msgBox.innerText = !name ? "Tell me your name!" : "Phone is required!";
                void chara.offsetWidth; // リフロー
                chara.classList.add('soy-appear');
            }
            if (!name && nameInput) {
                nameInput.focus();
                nameInput.classList.add('border-[#e60012]', 'bg-red-50');
                setTimeout(() => nameInput.classList.remove('border-[#e60012]', 'bg-red-50'), 2000);
            } else if (!phone && phoneInput) {
                phoneInput.focus();
                phoneInput.classList.add('border-[#e60012]', 'bg-red-50');
                setTimeout(() => phoneInput.classList.remove('border-[#e60012]', 'bg-red-50'), 2000);
            }
            return;
        }

        // 送信ボタンの「タメ」演出
        const btn = document.getElementById('submit-order-btn');
        const originalBtnText = btn.innerHTML;
        btn.innerHTML = `<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> SENDING...`;
        btn.disabled = true;
        btn.classList.add('opacity-80', 'cursor-wait');

        let total = 0;
        this.state.cart.forEach(item => total += item.price);

        try {
            // CSRFトークンの取得
            const csrfToken = document.querySelector('meta[name="csrf-token"]');

            // 1. APIに投げてDB保存
            const response = await fetch('/api/orders', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken ? csrfToken.content : ''
                },
                body: JSON.stringify({
                    customer_name: name,
                    customer_phone: phone,
                    order_type: type,
                    notes: notes,
                    total_price: total,
                    items: this.state.cart
                })
            });

            const result = await response.json();
            if (!result.success) throw new Error('DB Save Failed');

            const orderNumber = result.order_number;

            // 2. ブラウザに注文状態を記憶させる (2時間有効)
            localStorage.setItem('soya_active_order', JSON.stringify({
                orderNumber: orderNumber,
                timestamp: Date.now()
            }));

            // 3. WhatsApp用テキスト生成
            let text = `*NEW ORDER - Söya Menzah9*\n`;
            text += `*Order ID:* #${orderNumber}\n`;
            text += `------------------------\n`;
            text += `*Guest:* ${name}\n`;
            text += `*Phone:* ${phone}\n`;
            text += `*Type:* ${type}\n`;
            if (notes) text += `*Notes:* ${notes}\n`;
            text += `------------------------\n`;

            this.state.cart.forEach(item => {
                text += `1x ${item.name} - ${item.price.toFixed(3)} DT\n`;
                if (item.variants.length > 0) {
                    const extras = item.variants.map(v => v.name).join(', ');
                    text += `   + ${extras}\n`;
                }
            });
            text += `------------------------\n`;
            text += `*Total:* ${total.toFixed(3)} DT\n\n`;
            text += `_Waiting for shop confirmation..._`;

            // WhatsApp遷移
            const waNumber = '216557786656';
            const waUrl = `https://wa.me/${waNumber}?text=${encodeURIComponent(text)}`;
            window.open(waUrl, '_blank');

            // 4. 後始末とステータスバー表示
            this.state.cart = [];
            this.updateCartBar();
            if (nameInput) nameInput.value = '';
            if (phoneInput) phoneInput.value = '';
            if (notesInput) notesInput.value = '';

            btn.innerHTML = originalBtnText;
            btn.disabled = false;
            btn.classList.remove('opacity-80', 'cursor-wait');

            this.closeCheckout();
            this.checkActiveOrder();

        } catch (error) {
            console.error(error);
            alert("Something went wrong. Please check your connection.");
            btn.innerHTML = originalBtnText;
            btn.disabled = false;
            btn.classList.remove('opacity-80', 'cursor-wait');
        }
    },

    checkActiveOrder() {
        const orderData = JSON.parse(localStorage.getItem('soya_active_order'));
        if (!orderData) return;

        const now = Date.now();
        const twoHours = 2 * 60 * 60 * 1000;

        // 2時間以上経過していたら破棄
        if (now - orderData.timestamp > twoHours) {
            this.clearOrderStatus();
            return;
        }

        const statusBar = document.getElementById('order-status-bar');
        const orderNumberEl = document.getElementById('status-order-number');
        if (statusBar && orderNumberEl) {
            orderNumberEl.innerText = `#${orderData.orderNumber}`;
            statusBar.classList.remove('hidden');
            statusBar.classList.add('flex');
            setTimeout(() => {
                statusBar.classList.remove('translate-y-full');
            }, 50);
        }
    },

    clearOrderStatus() {
        localStorage.removeItem('soya_active_order');
        const statusBar = document.getElementById('order-status-bar');
        if (statusBar) {
            statusBar.classList.add('translate-y-full');
            setTimeout(() => {
                statusBar.classList.add('hidden');
                statusBar.classList.remove('flex');
            }, 500);
        }
    }
};
