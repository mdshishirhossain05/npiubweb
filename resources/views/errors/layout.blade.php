<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('code') — NPI University of Bangladesh</title>
    <style>
        :root { --ink:#0a0a0a; --green:#0f8550; --muted:#64748b; }
        * { box-sizing: border-box; }
        body {
            margin:0; min-height:100vh; display:flex; align-items:center; justify-content:center;
            font-family: 'Inter', system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
            color: var(--ink); background:#fff; padding:24px;
        }
        .wrap { max-width:520px; text-align:center; }
        .code { font-size:88px; font-weight:700; letter-spacing:-0.04em; line-height:1; color:var(--green); }
        h1 { font-size:24px; letter-spacing:-0.02em; margin:16px 0 8px; }
        p { color:var(--muted); line-height:1.6; margin:0 0 28px; }
        .btn {
            display:inline-block; background:var(--green); color:#fff; text-decoration:none;
            padding:12px 22px; border-radius:8px; font-weight:600; font-size:14px;
        }
        .btn:hover { background:#0c6b41; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="code">@yield('code')</div>
        <h1>@yield('title')</h1>
        <p>@yield('message')</p>
        <a class="btn" href="{{ url('/') }}">Back to homepage</a>
    </div>
</body>
</html>
