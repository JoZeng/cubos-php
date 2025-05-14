<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Charge;
use App\Models\Client;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function home()
    {
        return view('home');
    }

   public function index()
{
    $user = Auth::user();

    // Filtrar cobranças e clientes para o usuário autenticado
     // Filtrar os clientes do usuário autenticado
    $clients = Client::where('user_id', $user->id)->get(); 

    $charges = Charge::whereIn('client_id', $clients->pluck('id'))->get(); // Buscar cobranças pelos clientes do usuário

    $pagas = [];
    $vencidas = [];
    $previstas = [];

    foreach ($charges as $charge) {
        $expirationDate = Carbon::parse($charge->expiration);
        if ($charge->status === 'paga') {
            $pagas[] = $charge;
        } elseif ($charge->status === 'pendente') {
            if ($expirationDate->isPast()) {
                $vencidas[] = $charge;
            } else {
                $previstas[] = $charge;
            }
        }
    }

    // Totais gerais
    $totalPago = array_sum(array_column($pagas, 'value'));
    $totalVencidas = array_sum(array_column($vencidas, 'value'));
    $totalPrevista = array_sum(array_column($previstas, 'value'));

    // Separar clientes por status
    $clientesEmDia = [];
    $clientesInadimplentes = [];

    foreach ($clients as $client) {
        $totalPagoCliente = $client->charges->where('status', 'paga')->sum('value');
        $totalPendenteCliente = $client->charges->where('status', 'pendente')->sum('value');

        $status = $totalPagoCliente >= $totalPendenteCliente ? 'em dia' : 'inadimplente';

        $clientData = [
            'nome_cliente' => $client->name,
            'id' => $client->id,
            'totalPago' => $totalPagoCliente,
            'totalPendente' => $totalPendenteCliente,
            'status' => $status,
            'cpf' => $client->cpf,
        ];

        if ($status === 'em dia') {
            $clientesEmDia[] = $clientData;
        } else {
            $clientesInadimplentes[] = $clientData;
        }
    }

    // Contagens
    $totalClientesEmDiaCount = count($clientesEmDia);
    $totalClientesInadimplentesCount = count($clientesInadimplentes);
    $totalPagasCount = count($pagas);
    $totalVencidasCount = count($vencidas);
    $totalPrevistasCount = count($previstas);

    // Reduzir para exibição
    $clientesEmDia = array_slice($clientesEmDia, 0, 4);
    $clientesInadimplentes = array_slice($clientesInadimplentes, 0, 4);
    $pagas = array_slice($pagas, 0, 4);
    $vencidas = array_slice($vencidas, 0, 4);
    $previstas = array_slice($previstas, 0, 4);

    return view('home', [
        'user' => $user,
        'totalPago' => $totalPago,
        'totalVencidas' => $totalVencidas,
        'totalPrevista' => $totalPrevista,
        'clientesEmDia' => $clientesEmDia,
        'clientesInadimplentes' => $clientesInadimplentes,
        'pagas' => $pagas,
        'vencidas' => $vencidas,
        'previstas' => $previstas,
        'totalClientesEmDiaCount' => $totalClientesEmDiaCount,
        'totalClientesInadimplentesCount' => $totalClientesInadimplentesCount,
        'totalPagasCount' => $totalPagasCount,
        'totalVencidasCount' => $totalVencidasCount,
        'totalPrevistasCount' => $totalPrevistasCount,
    ]);
}

}
