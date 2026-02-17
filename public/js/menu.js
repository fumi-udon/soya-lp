/**
 * Söya. Modern Menu Logic
 */
window.App = {
    state: {
        cart: [],
        currentProduct: null,
        selectedType: null,
        selectedExtras: []
    },

    openModal(productId) {
        const product = window.ALL_PRODUCTS.find(p => p.id === productId);
        if (!product) return;

        this.state.currentProduct = product;
        this.state.selectedType = null;
        this.state.selectedExtras = [];

        // ギミックリセット
        const chara = document.getElementById('soy-character');
        chara.classList.remove('soy-appear');
        // ★英語メッセージに変更
        const msgBox = chara.querySelector('div');
        if(msgBox) msgBox.innerText = "Please select a style.";

        const btn = document.getElementById('add-to-cart-btn');
        btn.innerHTML = `ADD TO ORDER`;

        // 商品情報注入
        document.getElementById('modal-product-name').innerText = product.name;
        document.getElementById('modal-description').innerHTML = product.description ? product.description : '';
        const ingEl = document.getElementById('modal-ingredients');
        ingEl.innerText = product.ingredients ? `Contains: ${product.ingredients}` : '';
        ingEl.style.display = product.ingredients ? 'block' : 'none';

        // バリアント生成
        const types = product.product_variants.filter(v => v.is_required);
        const extras = product.product_variants.filter(v => !v.is_required);
        const container = document.getElementById('modal-options');
        container.innerHTML = '';

        // --- STYLE (必須) ---
        if (types.length > 0) {
            const typeSection = document.createElement('div');
            typeSection.className = "mb-8";
            // ★パルスアニメーションクラス (.required-pulse) を付与
            typeSection.innerHTML = `
                <p id="style-label" class="text-[10px] font-bold tracking-[0.2em] uppercase text-gray-400 mb-4 transition-all required-pulse">
                    Select Style <span class="text-[#e60012]">*</span>
                </p>`;

            const grid = document.createElement('div');
            grid.className = "flex flex-col gap-3";

            types.forEach(variant => {
                const btn = document.createElement('div');
                btn.className = "type-option relative overflow-hidden flex justify-between items-center p-4 rounded-xl border border-gray-100 bg-white shadow-sm cursor-pointer transition-all hover:border-gray-300";
                btn.dataset.id = variant.id;

                btn.innerHTML = `
                    <div class="flex items-center gap-4">
                        <div class="icon-slot w-5 h-5 rounded-full border border-gray-200 flex items-center justify-center bg-gray-50"></div>
                        <span class="text-sm font-bold text-gray-700">${variant.name}</span>
                    </div>
                    <span class="text-xs font-medium text-gray-500 bg-gray-50 px-2 py-1 rounded-md">${parseFloat(variant.price_adjustment).toFixed(3)} DT</span>
                `;
                btn.onclick = () => this.selectType(variant, btn);
                grid.appendChild(btn);
            });
            typeSection.appendChild(grid);
            container.appendChild(typeSection);
        }

        // --- TOPPINGS (任意) ---
        if (extras.length > 0) {
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
        modal.classList.remove('hidden');
        setTimeout(() => { modal.classList.add('active'); }, 10);
    },

    selectType(variant, element) {
        this.state.selectedType = variant;

        // ギミック: 醤油ちゃんを隠す
        document.getElementById('soy-character').classList.remove('soy-appear');

        // ★選択されたのでパルスを停止し、色を確定させる
        const styleLabel = document.getElementById('style-label');
        if (styleLabel) {
            styleLabel.classList.remove('required-pulse');
            styleLabel.classList.add('text-gray-900'); // 濃い色にして「選択済」感を出す
        }

        document.querySelectorAll('.type-option').forEach(el => {
            el.className = "type-option relative overflow-hidden flex justify-between items-center p-4 rounded-xl border border-gray-100 bg-white shadow-sm cursor-pointer transition-all";
            el.querySelector('.icon-slot').innerHTML = '';
            el.querySelector('.icon-slot').className = "icon-slot w-5 h-5 rounded-full border border-gray-200 flex items-center justify-center bg-gray-50";
        });

        element.className = "type-option relative overflow-hidden flex justify-between items-center p-4 rounded-xl border-2 border-[#1a1a1a] bg-white shadow-lg cursor-pointer transform scale-[1.01] transition-all";

        const iconSlot = element.querySelector('.icon-slot');
        iconSlot.className = "icon-slot w-5 h-5 flex items-center justify-center";
        iconSlot.innerHTML = `
            <svg viewBox="0 0 24 24" class="w-5 h-5 text-[#e60012] animate-roll">
                <path fill="currentColor" d="M12,2 C17.52,2 22,6.48 22,12 C22,17.52 17.52,22 12,22 C6.48,22 2,17.52 2,12 C2,6.48 6.48,2 12,2 Z M12,6 L12,18 M6,12 L18,12" />
            </svg>
        `;

        this.updateTotal();
    },

    toggleExtra(variant, element) {
        const index = this.state.selectedExtras.findIndex(v => v.id === variant.id);
        const checkbox = element.querySelector('.checkbox');

        if (index > -1) {
            this.state.selectedExtras.splice(index, 1);
            checkbox.classList.remove('bg-[#e60012]', 'border-[#e60012]');
            checkbox.innerHTML = '';
        } else {
            this.state.selectedExtras.push(variant);
            checkbox.classList.add('bg-[#e60012]', 'border-[#e60012]');
            checkbox.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>';
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
        btn.innerHTML = `ADD TO ORDER — <span class="ml-1">${total.toFixed(3)} DT</span>`;
    },

    confirm() {
        const hasTypes = this.state.currentProduct.product_variants.some(v => v.is_required);

        // ★必須未選択時のお叱り演出
        if (hasTypes && !this.state.selectedType) {
            const chara = document.getElementById('soy-character');
            chara.classList.remove('soy-appear');
            void chara.offsetWidth; // リフロー
            chara.classList.add('soy-appear');
            return;
        }

        // 注文処理
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
        const total = this.state.cart.reduce((sum, item) => sum + item.price, 0);
        document.getElementById('cart-count').innerText = this.state.cart.length;
        document.getElementById('cart-total').innerText = total.toFixed(3);
        if (this.state.cart.length > 0) bar.classList.remove('hidden');
    },

    close() {
        const modal = document.getElementById('product-modal');
        modal.classList.remove('active');
        setTimeout(() => { modal.classList.add('hidden'); }, 300);
    }
};
