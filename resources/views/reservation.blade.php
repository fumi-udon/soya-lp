@extends('layouts.soya')

@section('title', 'Reservation | Söya.')

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

                @if (session('success'))
                    <div class="alert alert-success text-center mb-4" role="status"
                        style="font-size: 0.85rem; letter-spacing: 0.05em;">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger text-center mb-4" role="alert"
                        style="font-size: 0.85rem; letter-spacing: 0.05em;">
                        {{ session('error') }}
                    </div>
                @endif

                <form id="resForm" method="POST" action="{{ route('reservation.store') }}"
                    class="animate__animated animate__fadeIn" style="animation-delay: 0.5s;">
                    @csrf

                    <div class="form-group">
                        <label class="label-min" for="name">GUEST NAME</label>
                        <input type="text" id="name" name="name" class="input-soya" placeholder="TYPE YOUR NAME"
                            value="{{ old('name') }}" required>
                        @error('name')
                            <span class="text-danger small d-block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-7">
                            <div class="form-group">
                                <label class="label-min" for="date">SELECT DATE</label>
                                <input type="date" id="date" name="date" class="input-soya"
                                    value="{{ old('date') }}" required>
                                @error('date')
                                    <span class="text-danger small d-block mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <label class="label-min" for="time">TIME</label>
                                <select id="time" name="time" class="input-soya" required>
                                    <option value="">--:--</option>
                                    <option value="12:00" @selected(old('time') === '12:00')>12:00</option>
                                    <option value="19:00" @selected(old('time') === '19:00')>19:00</option>
                                </select>
                                @error('time')
                                    <span class="text-danger small d-block mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="label-min" for="guests">PARTY SIZE</label>
                        <select id="guests" name="guests" class="input-soya" required>
                            @for ($i = 1; $i <= 6; $i++)
                                <option value="{{ $i }}" @selected(old('guests', '2') == $i)>
                                    {{ $i }} {{ $i > 1 ? 'PEOPLE' : 'PERSON' }}
                                </option>
                            @endfor
                        </select>
                        @error('guests')
                            <span class="text-danger small d-block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" id="submitBtn" class="btn-submit-reservation">
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
            const $submitBtn = $('#submitBtn');
            const $inputs = $('.input-soya');
            const $scroller = $('.photo-scroller');

            // --- 1. 麺の躍動感演出 ---
            $inputs.on('focus', function() {
                $scroller.css('animation-duration', '20s');
            }).on('blur', function() {
                $scroller.css('animation-duration', '60s');
            });

            $submitBtn.on('mousedown', function() {
                $(this).css('transform', 'scaleX(1.1) scaleY(0.8)');
            }).on('mouseup mouseleave', function() {
                $(this).css('transform', 'scale(1)');
            });

            // --- 2. 日付制限 ---
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            $('#date').attr('min', tomorrow.toISOString().split('T')[0]);
        });
    </script>
@endpush
