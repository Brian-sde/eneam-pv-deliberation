<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion - PV de délibération</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center;
               font-family: system-ui, "Segoe UI", sans-serif; background: #f1f5f9; color: #0f172a; }
        .card { width: 100%; max-width: 380px; background: #fff; padding: 32px; border-radius: 12px;
                box-shadow: 0 4px 24px rgba(15, 23, 42, .08); }
        h1 { margin: 0 0 24px; font-size: 1.4rem; }
        label { display: block; margin-bottom: 6px; font-size: .85rem; font-weight: 600; }
        input[type=email], input[type=password] { width: 100%; padding: 10px 12px; margin-bottom: 16px;
                border: 1px solid #cbd5e1; border-radius: 8px; font-size: 1rem; }
        button { width: 100%; padding: 11px; border: 0; border-radius: 8px; background: #2563eb;
                 color: #fff; font-size: 1rem; font-weight: 600; cursor: pointer; }
        button:hover { background: #1d4ed8; }
        .error { margin-bottom: 16px; padding: 10px 12px; border-radius: 8px;
                 background: #fee2e2; color: #991b1b; font-size: .9rem; }
    </style>
</head>
<body>
    <div class="card">
        <h1>PV de délibération</h1>

        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login.attempt') }}">
            @csrf
            <label for="email">Adresse e-mail</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>

            <label for="password">Mot de passe</label>
            <input id="password" type="password" name="password" required>

            <button type="submit">Se connecter</button>
        </form>
    </div>
</body>
</html>