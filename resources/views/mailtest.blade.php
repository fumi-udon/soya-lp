<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mail Test</title>
    <style>
        body { font-family: sans-serif; max-width: 520px; margin: 2rem auto; padding: 0 1rem; }
        .ok { color: green; }
        .ng { color: crimson; }
        button { margin: 0.5rem 0.5rem 0.5rem 0; padding: 0.5rem 1rem; cursor: pointer; }
        dl { background: #f5f5f5; padding: 1rem; border-radius: 6px; }
        dt { font-weight: bold; margin-top: 0.5rem; }
        dt:first-child { margin-top: 0; }
    </style>
</head>
<body>
    <h1>Mail Test</h1>

    <dl>
        <dt>Recipient</dt>
        <dd>{{ $recipient ?: '(empty)' }}</dd>
        <dt>TAKEOUT_MAIL_SEND</dt>
        <dd class="{{ $sendEnabled ? 'ok' : 'ng' }}">{{ $sendEnabled ? 'true' : 'false' }}</dd>
        <dt>From</dt>
        <dd>{{ $fromAddress }}</dd>
        <dt>SMTP Host</dt>
        <dd>{{ $mailHost }}</dd>
    </dl>

    @if (session('success'))
        <p class="ok">{{ session('success') }}</p>
    @endif
    @if (session('error'))
        <p class="ng">{{ session('error') }}</p>
    @endif

    <form method="POST" action="{{ route('mailtest.send', request()->query()) }}">
        @csrf
        <button type="submit" name="type" value="raw">Send raw test mail</button>
        <button type="submit" name="type" value="reservation">Send reservation test mail</button>
    </form>
</body>
</html>
