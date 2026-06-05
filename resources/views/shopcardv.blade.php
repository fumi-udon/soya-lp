<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Söya. | Vertical Shop Card</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Montserrat', 'Noto Serif JP', 'sans-serif'],
                        serif: ['Playfair Display', 'Noto Serif JP', 'serif'],
                    },
                    colors: {
                        'ecru': '#F4F1EB', 
                        'charcoal': '#2D2B2A', 
                    }
                },
            },
        };
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&family=Noto+Serif+JP:wght@300;400;500;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Montserrat', 'Noto Serif JP', sans-serif; }
        .font-serif { font-family: 'Playfair Display', 'Noto Serif JP', serif; }

        .vertical-text {
            writing-mode: vertical-rl;
            text-orientation: mixed;
        }

        @media print {
            @page { size: 55mm 85mm; margin: 0; }
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

<body class="min-h-screen flex flex-col items-center justify-center gap-6 bg-gray-200 p-6 print:p-0 print:bg-white print:min-h-0 print:block">

    <button type="button" onclick="window.print()"
            class="fixed top-4 right-4 z-50 inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-charcoal text-ecru text-sm font-medium shadow-md active:scale-95 transition print:hidden">
        印刷する
    </button>

    <div class="relative flex flex-col justify-end p-5 bg-ecru text-charcoal w-[55mm] h-[85mm] box-border shadow-xl print:shadow-none overflow-hidden" style="print-color-adjust: exact;">

        <div class="absolute top-5 right-2.5 vertical-text">
            <span class="text-[5pt] font-serif font-medium tracking-[0.5em] text-charcoal/75 leading-none">
                北と北 × Tokyo Current
            </span>
        </div>

        <div class="flex-grow"></div>

        <div class="w-full flex flex-col mb-1">
            
            <div class="mb-4">
                <h1 class="font-serif text-[32pt] font-semibold leading-none tracking-widest mb-1.5">SÖYA.</h1>
                <div class="text-[5pt] font-medium tracking-[0.25em] uppercase text-charcoal/90">
                    Craft Ramen & Gyoza 
                </div>
                <div class="text-[4.5pt] tracking-[0.2em] uppercase text-charcoal/80 mt-1">
                    Prod. Bistronippon
                </div>
            </div>

            <div class="flex items-end justify-between border-t border-charcoal/20 pt-3">
                
                <div class="flex flex-col gap-1">
                    <div class="flex items-center">
                        <span class="w-[4mm] text-[3.5pt] font-medium tracking-widest text-charcoal/50">IG</span>
                        <span class="text-[4.5pt] font-medium tracking-widest text-charcoal/90">@soya.tunis</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-[4mm] text-[3.5pt] font-medium tracking-widest text-charcoal/50">WA</span>
                        <span class="text-[4.5pt] font-medium tracking-widest text-charcoal/90">54 497 077</span>
                    </div>
                </div>

                {{-- QRコードは後で入れる（スペースのみ確保） --}}
                <div class="w-[12mm] h-[12mm]"></div>

            </div>
        </div>
    </div>

</body>
</html>