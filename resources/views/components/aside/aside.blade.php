<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/components/aside/aside.css', 'resources/js/app.js'])

</head>

<body>
    <aside class="aside-menu">
        <nav>
            <ul class="d-flex flex-column gap-5">
                <li>
                    <a href="/home"
                        class="d-flex flex-column align-items-center aside-link @if (request()->is('home')) active-link @endif">
                        <img src="{{ $homeImage }}" alt="{{ $homeAlt }}">
                        Home
                    </a>
                </li>
                <li>
                    <a href="/clientes"
                        class="d-flex flex-column align-items-center aside-link @if (request()->is('clientes')) active-link @endif">
                        <img src="{{ $clientImage }}" alt="{{ $clientAlt }}">
                        Clientes
                    </a>
                </li>
                <li>
                    <a href="/cobrancas"
                        class="d-flex flex-column align-items-center aside-link @if (request()->is('cobrancas')) active-link @endif">
                        <img src="{{ $chargeImage }}" alt="{{ $chargeAlt }}">
                        Cobranças
                    </a>
                </li>
            </ul>
        </nav>
    </aside>
</body>

</html>
