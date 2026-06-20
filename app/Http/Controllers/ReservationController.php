<?php

namespace App\Http\Controllers;

use App\Mail\NewReservationNotification;
use App\Support\ReservationSlots;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ReservationController extends Controller
{
    /** @return array<string, mixed> */
    protected function holidayConfig(): array
    {
        return [
            'is_active' => true,
            'start' => '2026-02-18',
            'end' => '2026-03-12',
            'title' => 'RAMADAN BREAK',
            'message' => "We are currently closed for the holy month of Ramadan.\nPreparing for our Grand Opening.",
            'period_txt' => 'Feb 15 – March 12, 2026',
        ];
    }

    protected function isClosed(): bool
    {
        $holiday = $this->holidayConfig();

        return $holiday['is_active'] && now()->between($holiday['start'], $holiday['end']);
    }

    public function create(): View
    {
        $pending = session('reservation.pending', []);

        return view('reservation.create', [
            'holiday' => $this->holidayConfig(),
            'isClosed' => $this->isClosed(),
            'timeSlots' => ReservationSlots::allowedTimes(),
            'minDate' => now()->toDateString(),
            'maxDate' => now()->addDays(7)->toDateString(),
            'formValues' => [
                'name' => old('name', $pending['name'] ?? ''),
                'date' => old('date', $pending['date'] ?? ''),
                'time' => old('time', $pending['time'] ?? ''),
                'guests' => old('guests', $pending['guests'] ?? '2'),
            ],
        ]);
    }

    public function confirm(Request $request): RedirectResponse
    {
        if ($this->isClosed()) {
            return redirect()->route('reservation')->with('error', 'Reservations are currently unavailable.');
        }

        try {
            $validated = $this->validateReservation($request);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()
                ->route('reservation')
                ->withErrors($e->validator)
                ->withInput();
        }

        session(['reservation.pending' => $validated]);

        return redirect()->route('reservation.confirm');
    }

    protected function formatBookingDate(string $date): string
    {
        return Carbon::parse($date)->format('d/m/Y');
    }

    public function showConfirm(): View|RedirectResponse
    {
        if ($this->isClosed()) {
            return redirect()->route('reservation')->with('error', 'Reservations are currently unavailable.');
        }

        $pending = session('reservation.pending');
        if (! is_array($pending)) {
            return redirect()->route('reservation');
        }

        return view('reservation.confirm', [
            'reservation' => $pending,
            'formattedDate' => $this->formatBookingDate($pending['date']),
            'accessTelHref' => 'tel:'.preg_replace('/[^\d+]/', '', (string) config('services.soya.tel', '+21654497077')),
            'accessTelDisplay' => config('services.soya.tel_display', '54 497 077'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        if ($this->isClosed()) {
            return redirect()->route('reservation')->with('error', 'Reservations are currently unavailable.');
        }

        $pending = session('reservation.pending');
        if (! is_array($pending)) {
            return redirect()->route('reservation');
        }

        try {
            $validated = $this->validateReservationData($pending);
        } catch (\Illuminate\Validation\ValidationException $e) {
            session()->forget('reservation.pending');

            return redirect()
                ->route('reservation')
                ->with('error', 'Your session has expired. Please submit your reservation again.');
        }

        if (! config('mail.reservation_notification.send_enabled')) {
            Log::warning('reservation_mail_disabled');

            return redirect()
                ->route('reservation')
                ->withInput($validated)
                ->with('error', 'Reservation requests are temporarily unavailable. Please call us directly.');
        }

        $recipient = trim((string) config('mail.reservation_notification.address'));
        if ($recipient === '' || ! filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
            Log::warning('reservation_mail_no_valid_recipient', ['recipient' => $recipient]);

            return redirect()
                ->route('reservation')
                ->withInput($validated)
                ->with('error', 'Unable to send your request. Please try again later or contact us by phone.');
        }

        $reservationId = 'RES-'.now()->timestamp;

        try {
            Mail::to($recipient)->send(new NewReservationNotification(
                reservationId: $reservationId,
                customerName: $validated['name'],
                bookingDate: $validated['date'],
                bookingTime: $validated['time'],
                partySize: (int) $validated['guests'],
            ));
        } catch (\Throwable $e) {
            Log::error('reservation_mail_failed', [
                'reservation_id' => $reservationId,
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->route('reservation.confirm')
                ->with('error', 'Unable to send your request. Please try again later or contact us by phone.');
        }

        session()->forget('reservation.pending');
        session([
            'reservation.completed' => [
                'reservation_id' => $reservationId,
                'name' => $validated['name'],
                'date' => $validated['date'],
                'time' => $validated['time'],
                'guests' => (int) $validated['guests'],
            ],
        ]);

        return redirect()->route('reservation.complete');
    }

    public function complete(): View|RedirectResponse
    {
        $completed = session()->pull('reservation.completed');
        if (! is_array($completed)) {
            return redirect()->route('reservation');
        }

        return view('reservation.complete', [
            'reservation' => $completed,
            'formattedDate' => $this->formatBookingDate($completed['date']),
            'accessTelHref' => 'tel:'.preg_replace('/[^\d+]/', '', (string) config('services.soya.tel', '+21654497077')),
            'accessTelDisplay' => config('services.soya.tel_display', '54 497 077'),
        ]);
    }

    /** @return array{name: string, date: string, time: string, guests: int} */
    protected function validateReservation(Request $request): array
    {
        return $this->validateReservationData($request->all());
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array{name: string, date: string, time: string, guests: int}
     */
    protected function validateReservationData(array $data): array
    {
        $allowedTimes = ReservationSlots::allowedTimes();
        $maxDate = now()->addDays(7)->toDateString();

        /** @var array{name: string, date: string, time: string, guests: int} $validated */
        $validated = validator($data, [
            'name' => ['required', 'string', 'max:100'],
            'date' => [
                'required',
                'date',
                'after_or_equal:today',
                'before_or_equal:'.$maxDate,
                function (string $attribute, mixed $value, \Closure $fail): void {
                    if (Carbon::parse((string) $value)->isSunday()) {
                        $fail('We are closed on Sundays.');
                    }
                },
            ],
            'time' => ['required', Rule::in($allowedTimes)],
            'guests' => ['required', 'integer', 'min:1', 'max:6'],
        ])->validate();

        return $validated;
    }
}
