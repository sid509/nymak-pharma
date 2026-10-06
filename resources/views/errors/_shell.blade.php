<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>{{ $code }} · {{ $title }} — Nymak Pharma</title>
    <style>
        * { margin: 0; box-sizing: border-box; }
        body { font-family: Inter, ui-sans-serif, system-ui, -apple-system, 'Segoe UI', sans-serif;
               background: #f4f6f7; color: #12262e; min-height: 100vh;
               display: flex; align-items: center; justify-content: center; padding: 2rem; }
        .card { max-width: 30rem; text-align: center; }
        .logo { display: inline-block; background: #fff; border-radius: 0.9rem;
                padding: 0.5rem 0.9rem; box-shadow: 0 1px 3px rgba(9,24,29,.08); }
        .logo img { height: 2rem; width: auto; display: block; }
        .code { margin-top: 1.75rem; font-size: 4.5rem; font-weight: 800; line-height: 1;
                letter-spacing: -0.03em;
                background: linear-gradient(120deg, #1e9e2e, #0086d4);
                -webkit-background-clip: text; background-clip: text; color: transparent; }
        h1 { margin-top: 0.75rem; font-size: 1.5rem; font-weight: 700; letter-spacing: -0.01em; }
        p.lead { margin: 0.75rem auto 0; max-width: 24rem; font-size: 0.95rem;
                 line-height: 1.6; color: #45606b; }
        .actions { margin-top: 1.75rem; display: flex; flex-wrap: wrap; gap: 0.75rem; justify-content: center; }
        .actions a { display: inline-flex; align-items: center; border-radius: 999px;
                     padding: 0.65rem 1.5rem; font-size: 0.9rem; font-weight: 600;
                     text-decoration: none; transition: background .15s ease; }
        .actions a.primary { background: #1e9e2e; color: #fff; }
        .actions a.primary:hover { background: #178527; }
        .actions a.ghost { color: #1e7d2b; }
        .actions a.ghost:hover { background: #e6f4e7; }
    </style>
</head>
<body>
    <main class="card">
        <span class="logo"><img src="/images/brand/nymak-logo.png" alt="Nymak Pharma"></span>
        <p class="code">{{ $code }}</p>
        <h1>{{ $title }}</h1>
        <p class="lead">{{ $message }}</p>
        <div class="actions">
            <a class="primary" href="/">Back to home</a>
            <a class="ghost" href="/contact">Contact us</a>
        </div>
    </main>
</body>
</html>
