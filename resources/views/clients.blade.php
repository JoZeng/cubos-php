<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/clients.css'])
</head>

<body class="d-flex flex-row">
    <div class="clients-page">
        @include('components.aside.aside', [
            'homeImage' => asset('images/home.svg'),
            'homeAlt' => 'home',
            'clientImage' => asset('images/redclients.png'),
            'clientAlt' => 'redclient',
            'chargeImage' => asset('images/charges.png'),
            'chargeAlt' => 'charges',
        ])
        <div class="d-flex flex-column clients-page-content">
            <div>
                @include('components.header.header', [
                    'title' => 'Clientes',
                    'user' => $user,
                    'homeImage' => asset('images/home.png'),
                    'homeAlt' => 'redhome',
                    'clientImage' => asset('images/client.png'),
                    'clientAlt' => 'client',
                    'chargeImage' => asset('images/charges.png'),
                    'chargeAlt' => 'charges',
                ])
            </div>
            <hr />
            @include('components.layouts.clients.clients-content', [])
        </div>
    </div>
</body>

</html>
