<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/charges.css'])
</head>

<body class="d-flex flex-row">
    <div class="charges-page">
        @include('components.aside.aside', [
            'homeImage' => asset('images/home.svg'),
            'homeAlt' => 'home',
            'clientImage' => asset('images/clients.svg'),
            'clientAlt' => 'client',
            'chargeImage' => asset('images/redcharges.png'),
            'chargeAlt' => 'redcharges',
        ])
        <div class="d-flex flex-column charges-page-content">
            <div>
                @include('components.header.header', [
                    'title' => 'Cobranças',
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
            @include('components.layouts.charges.charges-content')
        </div>
    </div>
</body>

</html>
