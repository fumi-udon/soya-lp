<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Söya. | Shop Card</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Montserrat', 'Noto Serif JP', 'sans-serif'],
                        serif: ['Playfair Display', 'Noto Serif JP', 'serif'],
                    },
                },
            },
        };
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Noto+Serif+JP:wght@300;400;500;700&family=Playfair+Display:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Montserrat', 'Noto Serif JP', sans-serif; }
        .font-serif { font-family: 'Playfair Display', 'Noto Serif JP', serif; }

        /* 印刷時は名刺サイズちょうど・余白なし */
        @media print {
            @page { size: 85mm 55mm; margin: 0; }
            html, body {
                margin: 0;
                padding: 0;
                background: #ffffff;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>

<body class="min-h-screen flex flex-col items-center justify-center gap-6 bg-gray-100 p-6 print:p-0 print:bg-white print:min-h-0 print:block">

    {{-- 印刷ボタン（右上・印刷物には出ない） --}}
    <button type="button" onclick="window.print()"
            class="fixed top-4 right-4 z-50 inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-[#1e2a45] text-[#e8dac1] text-sm font-bold shadow-md active:scale-95 transition print:hidden">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
             stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
        </svg>
        印刷する
    </button>

    {{-- 名刺カード本体 --}}
    <div class="relative flex flex-col items-center justify-between p-4 bg-[#1e2a45] text-[#e8dac1] w-[85mm] h-[55mm] font-sans text-center shadow-xl print:shadow-none box-border" style="print-color-adjust: exact;">

        <!-- 上部余白用スペーサー -->
        <div class="h-1"></div>

        <!-- 中央：ロゴ＆サブタイトル -->
        <div class="flex flex-col items-center justify-center w-full">
            <div class="font-serif text-[34pt] font-bold leading-none tracking-widest text-center">SÖYA.</div>
            <div class="text-[6.5pt] font-medium tracking-[0.3em] uppercase mt-2 opacity-90 text-center">
                Craft Ramen & Gyoza
            </div>
        </div>

        <!-- 下部：連絡先情報＆QRコード (水平配置) -->
        <div class="w-full flex items-center justify-between px-1 pb-1">
            
            <!-- 左：Instagram -->
            <div class="flex items-center gap-1.5 w-[32%] justify-start">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 opacity-90">
                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                    <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                </svg>
                <div class="text-[5.5pt] font-medium tracking-wider mt-[1px] opacity-90">@soya.tunis</div>
            </div>

            <!-- 中央：QRコード (テーマカラーに合わせて自動生成) -->
            <div class="flex items-center justify-center w-[36%]">
                <div class="p-[1.5mm] border border-[#e8dac1]/30 rounded-sm bg-[#1e2a45]">
                    <!-- https://soya.bistronippon.tn をQR化。色は名刺と同じ ネイビー(#1e2a45) と エクリュ(#e8dac1) -->
                    <img src="{{ asset('images/shopcard-qr.png') }}"
                         alt="QR code vers soya.bistronippon.tn"
                         class="w-[12mm] h-[12mm] object-contain">
                </div>
            </div>

            <!-- 右：WhatsApp -->
            <div class="flex items-center gap-1.5 w-[32%] justify-end">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 opacity-90">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.123 1.035 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.435 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                </svg>
                <div class="text-[6pt] font-bold tracking-wider mt-[1px] opacity-90">54 497 077</div>
            </div>
            
        </div>
    </div>

</body>
</html>