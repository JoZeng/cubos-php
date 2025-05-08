<?php

namespace App\Http\Controllers;

use App\Models\Charge;
use App\Models\Client;
use Illuminate\Http\Request;

class ChargeController extends Controller
{

    public function index()
    {
        $charges = Charge::all(); // Aqui você pode pegar todas as cobranças, ou pode adicionar algum filtro
        return view('charges.index', compact('charges')); // Retorna a view com as cobranças
    }

    public function store(Request $request)
    {
        // Validação dos dados recebidos
        $request->validate([
            'description' => 'required|string',
            'expiration' => 'required|date_format:d/m/Y',
            'value' => 'required|numeric',
            'status' => 'required|in:paga,pendente',
            'client_id' => 'required|exists:clients,id'
        ]);
    
        // Converte a data do formato brasileiro para formato MySQL
        $expiration = \DateTime::createFromFormat('d/m/Y', $request->expiration);
        if (!$expiration) {
            return back()->withErrors(['expiration' => 'Data de vencimento inválida.']);
        }
    
        // Cria a cobrança
        Charge::create([
            'description' => $request->description,
            'expiration' => $expiration->format('Y-m-d'),
            'value' => $request->value,
            'status' => $request->status,
            'client_id' => $request->client_id
        ]);
    
        return redirect()->back()->with('success', 'Cobrança cadastrada com sucesso!');
    }
    

    public function showClientStatus($clientId)
    {
        // Obter todas as cobranças do cliente
        $charges = Charge::where('client_id', $clientId)->get();
        
        // Calcular o total das cobranças pendentes e pagas
        $totalPendente = $charges->where('status', 'pendente')->sum('value');
        $totalPago = $charges->where('status', 'paga')->sum('value');
        
        // Determinar o status do cliente
        $status = $totalPendente > $totalPago ? 'inadimplente' : 'em dia';
        
        // Passar as informações para a view
        return view('clientes.detalhes', compact('clientId', 'status', 'totalPendente', 'totalPago'));
    }

    public function mostrarDetalhesCliente($id)
    {
        $clientId = Cliente::find($id)->id;  // Exemplo de obtenção do client_id
        dd($clientId);  // Aqui, o valor do clientId será exibido na tela, e a execução será interrompida

        return view('clientes.detalhes', compact('clientId'));
    }

    public function create()
    {
        $user = auth()->user();

        // Verifica se o usuário tem um cliente associado
        if (!$user->cliente) {
            return redirect()->route('some.route')->with('error', 'Usuário não possui cliente associado.');
        }

        // Obtém o ID do cliente associado ao usuário
        $client_id = $user->cliente->id;

        // Passa o client_id para a view
        return view('components.modals.modal-charges-add', compact('client_id'));
    }

}
