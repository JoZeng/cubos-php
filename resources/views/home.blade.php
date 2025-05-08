<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Resumo das Cobranças</title>
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
                    <div class="col-md-4">
                        @include('components.layouts.home.home-files', [
                            'countBackgroundColor' => 'blueCount',
                            'title' => 'Cobranças Pagas',
                            'clients' => 'Cliente',
                            'idcharges' => 'ID da cobrança',
                            'valuecharges' => 'Valor',
                            'names' => array_map(function ($c) {
                                return $c->client ? $c->client->name : 'Cliente Não Encontrado';
                            }, $pagas),
                            0,
                            4,
                            'ids' => array_map(function ($c) {
                                return '#' . $c->id;
                            }, $pagas),
                            0,
                            4,
                            'valuesOrCpfs' => array_map(function ($c) {
                                return $c->value;
                            }, $pagas),
                            0,
                            4,
                            'numbercount' => $totalPagasCount,
                        ])
                    </div>


                    <div class="col-md-4">
                        @include('components.layouts.home.home-files', [
                            'countBackgroundColor' => 'redCount',
                            'title' => 'Cobranças Vencidas',
                            'clients' => 'Cliente',
                            'idcharges' => 'ID da cobrança',
                            'valuecharges' => 'Valor',
                            'names' => array_map(function ($c) {
                                return $c->client ? $c->client->name : 'Cliente Não Encontrado';
                            }, $vencidas),
                            'ids' => array_map(function ($c) {
                                return '#' . $c->id;
                            }, $vencidas),
                            'valuesOrCpfs' => array_map(function ($c) {
                                return $c->value;
                            }, $vencidas),
                            'numbercount' => $totalVencidasCount,
                        ])
                    </div>
                    <div class="col-md-4">
                        @include('components.layouts.home.home-files', [
                            'countBackgroundColor' => 'yellowCount',
                            'title' => 'Cobranças Previstas',
                            'clients' => 'Cliente',
                            'idcharges' => 'ID da cobrança',
                            'valuecharges' => 'Valor',
                            'names' => array_map(function ($c) {
                                return $c->client ? $c->client->name : 'Cliente Não Encontrado';
                            }, $previstas),
                            'ids' => array_map(function ($c) {
                                return '#' . $c->id;
                            }, $previstas),
                            'valuesOrCpfs' => array_map(function ($c) {
                                return $c->value;
                            }, $previstas),
                            'numbercount' => $totalPrevistasCount,
                        ])
                    </div>
                </div>
                <div class="home-files-major">
                    <div class="col-md-6">
                        @include('components.layouts.home.home-files', [
                            'countBackgroundColor' => 'grayCount',
                            'title' => 'Clientes Inadimplentes',
                            'clients' => 'Cliente',
                            'idcharges' => 'ID',
                            'valuecharges' => 'CPF',
                            'names' => array_map(function ($c) {
                                return $c['nome_cliente'];
                            }, $clientesInadimplentes),
                            'ids' => array_map(function ($c) {
                                return '#' . $c['id'];
                            }, $clientesInadimplentes),
                            'valuesOrCpfs' => array_map(function ($c) {
                                return $c['cpf'];
                            }, $clientesInadimplentes),
                            'numbercount' => $totalClientesInadimplentesCount,
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.layouts.home.home-files', [
                            'countBackgroundColor' => 'greenCount',
                            'title' => 'Clientes em Dia',
                            'clients' => 'Cliente',
                            'idcharges' => 'ID',
                            'valuecharges' => 'CPF',
                            'names' => array_map(function ($c) {
                                return $c['nome_cliente'];
                            }, $clientesEmDia),
                            'ids' => array_map(function ($c) {
                                return '#' . $c['id'];
                            }, $clientesEmDia),
                            'valuesOrCpfs' => array_map(function ($c) {
                                return $c['cpf'];
                            }, $clientesEmDia),
                            'numbercount' => $totalClientesEmDiaCount,
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
