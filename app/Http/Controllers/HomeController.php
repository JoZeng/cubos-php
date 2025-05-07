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

        // Recuperando todas as cobranças
        $charges = Charge::all();
        $clients = Client::all();

        // Definindo variáveis para armazenar listas
        $pagas = [];
        $vencidas = [];
        $previstas = [];

        $clientesEmDia = [];
        $clientesInadimplentes = [];

        // Categorizar as cobranças por status
        foreach ($charges as $charge) {
            $status = $charge->status;
            $expirationDate = Carbon::parse($charge->expiration);
            $currentDate = Carbon::now();

            if ($status == 'paga') {
                $pagas[] = $charge;
            } elseif ($status == 'pendente') {
                if ($expirationDate->isPast()) {
                    $vencidas[] = $charge;
                } elseif ($expirationDate->isFuture()) {
                    $previstas[] = $charge;
                }
            }
        }

        // Calculando total das cobranças pagas, vencidas e previstas
        $totalPago = array_sum(array_column($pagas, 'value'));
        $totalVencidas = array_sum(array_column($vencidas, 'value'));
        $totalPrevista = array_sum(array_column($previstas, 'value'));

        // Filtrando os clientes
        $clientesEmDia = $this->getClientesStatus($clients, 'em dia');
        $clientesInadimplentes = $this->getClientesStatus($clients, 'inadimplente');
        $totalClientesEmDia = count($clientesEmDia);
        $totalClientesInadimplentes = count($clientesInadimplentes);
        $totalPagasCount = count($pagas);
        $totalVencidasCount = count($vencidas);
        $totalPrevistasCount = count($previstas);
        $clientesEmDia = array_slice($clientesEmDia, 0, 4);
        $clientesInadimplentes = array_slice($clientesInadimplentes, 0, 4);
        $pagas = array_slice($pagas, 0, 4); // Limitar pagas a 4
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
            'totalClientesEmDiaCount' => $totalClientesEmDia,
            'totalClientesInadimplentesCount' => $totalClientesInadimplentes,
            'totalPagasCount' => $totalPagasCount,
            'totalVencidasCount' => $totalVencidasCount,
            'totalPrevistasCount' => $totalPrevistasCount,
        ]);
    }

    // Função para categorizar os clientes como "em dia" ou "inadimplente"
    private function getClientesStatus($clients, $status)
    {
        $filteredClients = [];
        foreach ($clients as $client) {
            $totalPago = 0;
            $totalPendente = 0;

            // Obter cobranças do cliente
            $charges = $client->charges;

            foreach ($charges as $charge) {
                if ($charge->status == 'pago') {
                    $totalPago += $charge->value;
                } elseif ($charge->status == 'pendente') {
                    $totalPendente += $charge->value;
                }
            }

            // Verificar se o cliente está em dia ou inadimplente
            $clientStatus = $totalPago >= $totalPendente ? 'em dia' : 'inadimplente';

            if ($clientStatus == $status) {
                $filteredClients[] = [
                    'nome_cliente' => $client->name,
                    'id' => $client->id,
                    'totalPago' => $totalPago,
                    'totalPendente' => $totalPendente,
                    'status' => $clientStatus,
                ];
            }
        }

        return $filteredClients;
    }
}