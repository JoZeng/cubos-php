<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/home.css'])
</head>

<body class="d-flex flex-row">
    <div class="home-page">
        @include('components.aside.aside', [
            'homeImage' => asset('images/redhome.png'),
            'homeAlt' => 'redhome',
            'clientImage' => asset('images/client.png'),
            'clientAlt' => 'client',
            'chargeImage' => asset('images/charges.png'),
            'chargeAlt' => 'charges',
        ])
        <div class="d-flex flex-column home-page-content">
            <div>
                @include('components.header.header', [
                    'title' => 'Resumo das cobranças',
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
            <div class="home-content">
                @include('components.layouts.home.home-charges')
                <div class="home-files-minor">
                    @foreach ($pagas as $charge)
                        @include('components.layouts.home.home-files', [
                            'title' => 'Cobranças Pagas',
                            'clients' => 'Cliente',
                            'idcharges' => 'ID da cobrança',
                            'valuecharges' => 'Valor',
                            'name' => 'pinha',
                            'id' => $charge->id,
                            'valueOrCpf' => number_format($charge->value / 100, 2, ',', '.'),
                        ])
                    @endforeach

                    @foreach ($vencidas as $charge)
                        @include('components.layouts.home.home-files', [
                            'title' => 'Cobranças Vencidas',
                            'clients' => 'Cliente',
                            'idcharges' => 'ID da cobrança',
                            'valuecharges' => 'Valor',
                            'name' => 'pinha',
                            'id' => $charge->id,
                            'valueOrCpf' => number_format($charge->value / 100, 2, ',', '.'),
                        ])
                    @endforeach

                    @foreach ($previstas as $charge)
                        @include('components.layouts.home.home-files', [
                            'title' => 'Cobranças Previstas',
                            'clients' => 'Cliente',
                            'idcharges' => 'ID da cobrança',
                            'valuecharges' => 'Valor',
                            'name' => 'pinha',
                            'id' => $charge->id,
                            'valueOrCpf' => number_format($charge->value / 100, 2, ',', '.'),
                        ])
                    @endforeach
                </div>
                <div class="home-files-major">
                    @foreach ($clientesInadimplentes as $client)
                        @include('components.layouts.home.home-files', [
                            'title' => 'Clientes Inadimplentes',
                            'clients' => 'Cliente',
                            'idcharges' => 'ID da cobrança',
                            'valuecharges' => 'Valor',
                            'name' => 'pinha',
                            'id' => $client['id'],
                            'valueOrCpf' => number_format($client['totalPendente'] / 100, 2, ',', '.'),
                        ])
                    @endforeach

                    @foreach ($clientesEmDia as $client)
                        @include('components.layouts.home.home-files', [
                            'title' => 'Clientes em Dia',
                            'clients' => 'Cliente',
                            'idcharges' => 'ID da cobrança',
                            'valuecharges' => 'Valor',
                            'name' => 'pinha',
                            'id' => $client['id'],
                            'valueOrCpf' => number_format($client['totalPago'] / 100, 2, ',', '.'),
                        ])
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</body>

</html>
