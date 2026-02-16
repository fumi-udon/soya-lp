@extends('layouts.soya')

@section('title', 'Reservation | Söya.')

@php
    /* |--------------------------------------------------------------------------
       | RAMADAN SETTINGS (2026/02/15 - 03/12)
       |-------------------------------------------------------------------------- */
    $holiday = [
        'is_active' => true,
        'start' => '2026-02-18',
        'end' => '2026-03-12',
        'title' => 'RAMADAN BREAK',
        'message' => "We are currently closed for the holy month of Ramadan.\nPreparing for our Grand Opening.",
        'period_txt' => 'Feb 15 – March 12, 2026',
    ];

    $isClosed = $holiday['is_active'] && now()->between($holiday['start'], $holiday['end']);
@endphp

@section('content')
    {{-- 1. 背景：モノトーンの動的スライダー --}}
    <div class="gallery-wrapper">
        <div class="photo-scroller">
            @for ($j = 0; $j < 2; $j++)
                @for ($i = 1; $i <= 10; $i++)
                    <div class="photo-item" style="background-image: url('{{ asset('res_' . $i . '.png') }}')"></div>
                @endfor
            @endfor
        </div>
    </div>

    <div class="main-content">
        {{-- 2. ガラスコンテナ --}}
        <div class="content-container animate__animated animate__fadeInUp">

            @if ($isClosed)
                {{-- A. 休業告知モード --}}
                <div class="holiday-notice text-center">
                    <h2 class="animate__animated animate__fadeIn">{{ $holiday['title'] }}</h2>
                    <p class="mt-4"
                        style="font-family: 'Noto Serif JP', serif; font-weight: 300; line-height: 2.2; color: #4a4a4a;">
                        {!! nl2br(e($holiday['message'])) !!}
                    </p>
                    <div class="mt-5 pt-4" style="border-top: 1px solid rgba(0,0,0,0.05);">
                        <span class="small"
                            style="letter-spacing: 0.3em; color: #a3b8c9;">{{ $holiday['period_txt'] }}</span>
                    </div>
                </div>
            @else
                {{-- B. 予約フォームモード --}}
                <div class="brand-header text-center">
                    <h1>Res<span>.</span></h1>
                    <p class="sub">TOKYO CURRENT</p>
                </div>

                <form id="resForm" class="animate__animated animate__fadeIn" style="animation-delay: 0.5s;">
                    <div class="form-group">
                        <label class="label-min">GUEST NAME</label>
                        <input type="text" id="name" class="input-soya" placeholder="TYPE YOUR NAME" required>
                    </div>

                    <div class="row">
                        <div class="col-7">
                            <div class="form-group">
                                <label class="label-min">SELECT DATE</label>
                                <input type="date" id="date" class="input-soya" required>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <label class="label-min">TIME</label>
                                <select id="time" class="input-soya" required>
                                    <option value="">--:--</option>
                                    <option value="12:00">12:00</option>
                                    <option value="19:00">19:00</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="label-min">PARTY SIZE</label>
                        <select id="guests" class="input-soya">
                            @for ($i = 1; $i <= 6; $i++)
                                <option value="{{ $i }}">{{ $i }} {{ $i > 1 ? 'PEOPLE' : 'PERSON' }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <button type="button" id="whatsappBtn" class="btn-whatsapp">
                        <div class="btn-content">
                            <img src="{{ asset('hokkaido_2.png') }}" alt="Hokkaido" class="hokkaido-icon">
                            <span class="btn-text">SEND REQUEST</span>
                        </div>
                    </button>
                </form>
            @endif

            {{-- 3. フッター --}}
            <div class="text-center mt-5">
                <a href="{{ url('/') }}" class="back-link"
                    style="font-size: 0.55rem; color: #aaa; letter-spacing: 0.2em; text-decoration: none; text-transform: uppercase;">
                    TERMINAL / BACK TO HOME
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="module">
        $(function() {
            const $whatsappBtn = $('#whatsappBtn');
            const $inputs = $('.input-soya');
            const $scroller = $('.photo-scroller');

            // --- 1. 麺の躍動感演出 ---
            $inputs.on('focus', function() {
                $scroller.css('animation-duration', '20s'); // 背景加速
            }).on('blur', function() {
                $scroller.css('animation-duration', '60s'); // 減速
            });

            $whatsappBtn.on('mousedown', function() {
                $(this).css('transform', 'scaleX(1.1) scaleY(0.8)'); // 麺のコシ（弾力）
            }).on('mouseup mouseleave', function() {
                $(this).css('transform', 'scale(1)');
            });

            // --- 2. 予約送信 & AIデータ構造化 ---
            $whatsappBtn.on('click', function() {
                const name = $('#name').val();
                const date = $('#date').val();
                const time = $('#time').val();
                const guests = $('#guests').val();

                if (!name || !date || !time) {
                    alert('Please complete the form.');
                    return;
                }

                const resData = {
                    id: `RES-${Date.now()}`,
                    timestamp: new Date().toISOString(),
                    customer: name,
                    booking_date: date,
                    booking_time: time,
                    party_size: guests,
                    store: "Soya_Menzah9",
                    ver: "2.0"
                };

                // ブラウザログ保存
                const history = JSON.parse(localStorage.getItem('soya_res_logs') || '[]');
                history.push(resData);
                localStorage.setItem('soya_res_logs', JSON.stringify(history));

                // AI解析・WhatsApp用 YAMLフォーマット
                const text = `*NEW RESERVATION*
---
ID: ${resData.id}
NAME: ${resData.customer}
DATE: ${resData.booking_date}
TIME: ${resData.booking_time}
GUESTS: ${resData.party_size}
---
Generated by Söya-AI-Agent.
Please send this without modification.`;

                // GA4送信
                if (typeof gtag === 'function') {
                    gtag('event', 'generate_lead', {
                        'value': guests
                    });
                }

                window.open(`https://wa.me/216557786656?text=${encodeURIComponent(text)}`, '_blank');
            });

            // 日付制限
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            $('#date').attr('min', tomorrow.toISOString().split('T')[0]);
        });
    </script>
@endpush
