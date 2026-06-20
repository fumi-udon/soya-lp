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
        return view('reservation', [
            'holiday' => $this->holidayConfig(),
            'isClosed' => $this->isClosed(),
            'timeSlots' => ReservationSlots::allowedTimes(),
            'minDate' => now()->toDateString(),
            'maxDate' => now()->addDays(7)->toDateString(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        if ($this->isClosed()) {
            return back()->with('error', 'Reservations are currently unavailable.');
        }

        $allowedTimes = ReservationSlots::allowedTimes();
        $maxDate = now()->addDays(7)->toDateString();

        $validated = $request->validate([
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
        ]);

        if (! config('mail.reservation_notification.send_enabled')) {
            Log::warning('reservation_mail_disabled');

            return back()
                ->withInput()
                ->with('error', 'Reservation requests are temporarily unavailable. Please call us directly.');
        }

        $recipient = trim((string) config('mail.reservation_notification.address'));
        if ($recipient === '' || ! filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
            Log::warning('reservation_mail_no_valid_recipient', ['recipient' => $recipient]);

            return back()
                ->withInput()
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

            return back()
                ->withInput()
                ->with('error', 'Unable to send your request. Please try again later or contact us by phone.');
        }

        return back()->with('success', 'Your reservation request has been sent. We will contact you shortly.');
    }
}
