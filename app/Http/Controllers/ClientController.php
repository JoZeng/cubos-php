<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon; // Correto, sem duplicar "Carbon"
use Illuminate\Pagination\LengthAwarePaginator;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->input('search', '');
        $statusFilter = $request->input('status', null);
    
        // Recupera clientes com suas cobranças
        $clientsQuery = Client::with('charges')->where('user_id', $user->id);
    
        if (!empty($search)) {
            $clientsQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
                      ->orWhere('cpf', 'like', '%' . $search . '%');
            });
        }
    
        // Pega todos os clientes para calcular o status manualmente
        $clients = $clientsQuery->get();
    
        // Calcula o status de cada cliente com base nas cobranças
        $clients = $clients->map(function ($client) {
            $totalPendente = 0;
            $totalPago = 0;
    
            foreach ($client->charges as $charge) {
                if ($charge->status === 'pendente') {
                    $totalPendente += $charge->value;
                } elseif ($charge->status === 'paga') {
                    $totalPago += $charge->value;
                }
            }
    
            $client->calculated_status = $totalPendente > $totalPago ? 'Inadimplente' : 'Em dia';
            return $client;
        });
    
        // Filtra conforme o status desejado
        if ($statusFilter === 'inadimplente') {
            $clients = $clients->filter(function ($client) {
                return $client->calculated_status === 'Inadimplente';
            });
        } elseif ($statusFilter === 'em_dia') {
            $clients = $clients->filter(function ($client) {
                return $client->calculated_status === 'Em dia';
            });
        }
    
        // Paginação manual
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $pagedData = $clients->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $paginatedClients = new LengthAwarePaginator($pagedData, $clients->count(), $perPage, $currentPage);
    
        return view('clients', [
            'clients' => $paginatedClients->appends($request->only(['search', 'status'])),
            'search' => $search,
            'paginaAtual' => $paginatedClients->currentPage(),
            'totalPaginas' => $paginatedClients->lastPage(),
            'user' => $user,
            'client_id' => null,
            'charges' => $clients->pluck('charges')->flatten() // Plucking todas as cobranças dos clientes
        ]);
    }
    
    
    
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Exibe os detalhes de um cliente específico.
     */
    public function detailsClients($id)
    {
        $user = Auth::user();
    
        // Busca o cliente e suas cobranças, garantindo que pertença ao usuário autenticado
        $client = Client::with('charges')->where('user_id', $user->id)->findOrFail($id);
    
        // Adiciona o campo calculated_status para cada cobrança com base na data de vencimento
        foreach ($client->charges as $charge) {
            if ($charge->status === 'paga') {
                $charge->calculated_status = 'paga';
            } elseif ($charge->status === 'pendente') {
                $charge->calculated_status = Carbon::parse($charge->expiration)->isPast() ? 'vencida' : 'pendente';
            } else {
                $charge->calculated_status = 'desconhecido';
            }
        }

        return view('clients-details', [
            'client' => $client,
            'charges' => $client->charges, // já vêm com calculated_status
            'user' => $user,
        ]);
    }
    
    
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clients',
            'cpf' => 'nullable|string|max:14|unique:clients',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'complement' => 'nullable|string|max:255',
            'cep' => 'nullable|string|max:10',
            'neighborhood' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:2',
        ]);

        $client = new Client();
        $client->user_id = Auth::id();
        $client->name = $request->name;
        $client->email = $request->email;
        $client->cpf = $request->cpf;
        $client->phone = $request->phone;
        $client->address = $request->address;
        $client->complement = $request->complement;
        $client->cep = $request->cep;
        $client->neighborhood = $request->neighborhood;
        $client->city = $request->city;
        $client->state = $request->state;
        $client->save();

        return redirect()->route('clients')->with('success', 'Cliente adicionado com sucesso!');
    }

    public function show($id)
    {
        $client = Client::with('charges')->find($id);
        if (!$client) {
            return redirect()->route('clients')->with('error', 'Cliente não encontrado.');
        }

        return view('client-details', [
            'client' => $client,
            'client_id' => $client->id,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $client = Client::findOrFail($id);
        return view('clients.edit', ['client' => $client]);
    }

  

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clients,email,' . $id,
            'cpf' => 'nullable|string|max:14|unique:clients,cpf,' . $id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'complement' => 'nullable|string|max:255',
            'cep' => 'nullable|string|max:10',
            'neighborhood' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:2',
        ]);

        $client = Client::findOrFail($id);
        $client->name = $request->name;
        $client->email = $request->email;
        $client->cpf = $request->cpf;
        $client->phone = $request->phone;
        $client->address = $request->address;
        $client->complement = $request->complement;
        $client->cep = $request->cep;
        $client->neighborhood = $request->neighborhood;
        $client->city = $request->city;
        $client->state = $request->state;
        $client->save();

        return redirect()->route('clients')->with('success', 'Cliente atualizado com sucesso!');
    }

    
    public function destroy(string $id)
    {
        $client = Client::findOrFail($id);

        // Verifique se o cliente tem cobranças antes de excluir
        if ($client->charges()->count() > 0) {
            return redirect()->route('clients')->with('error', 'Este cliente possui cobranças associadas e não pode ser excluído.');
        }

        $client->delete();
        return redirect()->route('clients')->with('success', 'Cliente excluído com sucesso!');
    }

}
