@extends('layouts.soya-app')

@section('title', 'Réservation | Söya.')

@section('content')
    @if ($isClosed)
        <div class="soya-form-card text-center p-4">
            <h2 class="soya-page-title" style="font-size: 1.35rem;">
                {{ $holiday['title'] }}
            </h2>
            <p class="mt-3 text-sm leading-relaxed" style="color: #4a4a4a;">
                {!! nl2br(e($holiday['message'])) !!}
            </p>
            <p class="mt-4 pt-3 text-xs tracking-widest soya-text-muted" style="border-top: 1px solid rgba(0,0,0,0.05);">
                {{ $holiday['period_txt'] }}
            </p>
        </div>
    @else
        <div class="mb-2">
            <p class="soya-page-kicker">Réservation</p>
            <h1 class="soya-page-title">Réserver une table</h1>
            <p class="mt-1 text-xs leading-snug soya-text-muted">
                Lun – Sam · 12h00–14h45 · 18h30–21h45
            </p>
        </div>

        @if (session('error'))
            <div class="rounded-lg px-3 py-2 mb-2 text-xs"
                 style="background: #fff0f0; border: 1px solid rgba(230,0,18,0.25); color: #110A08;">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('reservation.confirm.submit') }}"
              id="resForm" class="soya-form-card soya-form-fields">
            @csrf

            <div>
                <label class="soya-label" for="name">Nom</label>
                <input type="text" id="name" name="name" class="soya-input"
                       placeholder="Votre nom" value="{{ $formValues['name'] }}" required>
                @error('name')
                    <span class="text-danger small d-block mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="soya-form-row-2">
                <div>
                    <label class="soya-label" for="date">Date</label>
                    <input type="date" id="date" name="date" class="soya-input"
                           value="{{ $formValues['date'] }}"
                           min="{{ $minDate }}"
                           max="{{ $maxDate }}"
                           required>
                    @error('date')
                        <span class="text-danger small d-block mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="soya-label" for="time">Heure</label>
                    <select id="time" name="time" class="soya-input" required>
                        <option value="">--:--</option>
                        @foreach ($timeSlots as $slot)
                            <option value="{{ $slot }}" @selected($formValues['time'] === $slot)>{{ $slot }}</option>
                        @endforeach
                    </select>
                    @error('time')
                        <span class="text-danger small d-block mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div>
                <label class="soya-label" for="guests">Personnes</label>
                <select id="guests" name="guests" class="soya-input" required>
                    @for ($i = 1; $i <= 6; $i++)
                        <option value="{{ $i }}" @selected((string) $formValues['guests'] === (string) $i)>
                            {{ $i }} {{ $i > 1 ? 'pers.' : 'pers.' }}
                        </option>
                    @endfor
                </select>
                @error('guests')
                    <span class="text-danger small d-block mt-1">{{ $message }}</span>
                @enderror
            </div>
        </form>
    @endif
@endsection

@if (! $isClosed)
@section('page-actions')
    <button type="submit" form="resForm" class="soya-btn-primary">
        Vérifier la réservation
    </button>
@endsection
@endif

@push('scripts')
    <script type="module">
        $('#date').on('change', function() {
            if (!this.value) return;
            const picked = new Date(this.value + 'T12:00:00');
            if (picked.getDay() === 0) {
                alert('Nous sommes fermés le dimanche.');
                this.value = '';
            }
        });
    </script>
@endpush
