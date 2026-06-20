@extends('layouts.soya-app')

@section('title', 'Réservation | Söya.')

@section('content')
    @if ($isClosed)
        <div class="rounded-2xl p-6 text-center"
             style="background: #ffffff; border: 1px solid rgba(163,184,201,0.3);">
            <h2 style="font-family: 'Playfair Display', serif; font-size: 1.75rem; color: #110A08;">
                {{ $holiday['title'] }}
            </h2>
            <p class="mt-4 text-sm leading-relaxed" style="color: #4a4a4a;">
                {!! nl2br(e($holiday['message'])) !!}
            </p>
            <p class="mt-5 pt-4 text-xs tracking-widest" style="color: #A3B8C9; border-top: 1px solid rgba(0,0,0,0.05);">
                {{ $holiday['period_txt'] }}
            </p>
        </div>
    @else
        <div class="mb-6">
            <p style="font-size: 0.65rem; font-weight: 700; color: #A3B8C9; letter-spacing: 0.2em; text-transform: uppercase;">
                Réservation
            </p>
            <h1 style="font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 700; color: #110A08; margin-top: 0.35rem;">
                Réserver une table
            </h1>
            <p class="mt-2 text-sm" style="color: #A3B8C9;">
                Lun – Sam · 12h00–14h45 · 18h30–21h45
            </p>
        </div>

        @if (session('error'))
            <div class="rounded-2xl p-4 mb-4 text-sm"
                 style="background: #fff0f0; border: 1px solid rgba(230,0,18,0.25); color: #110A08;">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('reservation.confirm.submit') }}"
              class="rounded-2xl p-5 flex flex-col gap-5"
              style="background: #ffffff; border: 1px solid rgba(163,184,201,0.3);">
            @csrf

            <div>
                <label class="soya-label" for="name">Nom</label>
                <input type="text" id="name" name="name" class="soya-input"
                       placeholder="Votre nom" value="{{ $formValues['name'] }}" required>
                @error('name')
                    <span class="text-danger small d-block mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
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
                <label class="soya-label" for="guests">Nombre de personnes</label>
                <select id="guests" name="guests" class="soya-input" required>
                    @for ($i = 1; $i <= 6; $i++)
                        <option value="{{ $i }}" @selected((string) $formValues['guests'] === (string) $i)>
                            {{ $i }} {{ $i > 1 ? 'personnes' : 'personne' }}
                        </option>
                    @endfor
                </select>
                @error('guests')
                    <span class="text-danger small d-block mt-1">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="soya-btn-primary mt-2">
                Vérifier la réservation
            </button>
        </form>
    @endif
@endsection

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
