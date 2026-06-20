<?php

namespace App\Http\Controllers;

use App\Mail\NewReservationNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class MailTestController extends Controller
{
    public function show(Request $request): View|Response
    {
        if (! $this->authorized($request)) {
            abort(404);
        }

        return view('mailtest', [
            'recipient' => config('mail.reservation_notification.address'),
            'sendEnabled' => (bool) config('mail.reservation_notification.send_enabled'),
            'fromAddress' => config('mail.from.address'),
            'mailHost' => config('mail.mailers.smtp.host'),
        ]);
    }

    public function send(Request $request): RedirectResponse|Response
    {
        if (! $this->authorized($request)) {
            abort(404);
        }

        $validated = $request->validate([
            'type' => ['required', 'in:raw,reservation'],
        ]);

        $recipient = trim((string) config('mail.reservation_notification.address'));
        if ($recipient === '' || ! filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
            return back()->with('error', 'Invalid recipient: MAIL_ORDER_NOTIFICATION_ADDRESS');
        }

        if (! config('mail.reservation_notification.send_enabled')) {
            return back()->with('error', 'TAKEOUT_MAIL_SEND is false — mail disabled.');
        }

        try {
            if ($validated['type'] === 'raw') {
                Mail::raw('Soya mail test at '.now()->toIso8601String(), function ($m) use ($recipient) {
                    $m->to($recipient)->subject('[TEST] Soya SMTP raw');
                });
            } else {
                Mail::to($recipient)->send(new NewReservationNotification(
                    reservationId: 'RES-TEST-'.now()->timestamp,
                    customerName: 'Mail Test',
                    bookingDate: now()->addDay()->format('Y-m-d'),
                    bookingTime: '19:00',
                    partySize: 2,
                ));
            }

            Log::info('mailtest_sent', ['type' => $validated['type'], 'recipient' => $recipient]);

            return back()->with('success', "Sent ({$validated['type']}) to {$recipient}");
        } catch (\Throwable $e) {
            Log::error('mailtest_failed', ['message' => $e->getMessage()]);

            return back()->with('error', $e->getMessage());
        }
    }

    protected function authorized(Request $request): bool
    {
        $token = (string) config('services.soya.mailtest_token', '');

        return $token !== '' && hash_equals($token, (string) $request->query('token', ''));
    }
}
