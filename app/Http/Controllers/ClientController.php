<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
        
        $clientsQuery = Client::with('charges')->where('user_id', $user->id);
        
        if (!empty($search)) {
            $clientsQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
                      ->orWhere('cpf', 'like', '%' . $search . '%');
            });
        }
        
        // Paginação apenas para clientes
        $clients = $clientsQuery->paginate(10);
        
        return view('clients', [
            'clients' => $clients,
            'search' => $search,
            'paginaAtual' => $clients->currentPage(),
            'totalPaginas' => $clients->lastPage(),
            'user' => $user,
            'client_id' => null,
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
    public function mostrarDetalhesCliente($id)
    {
        $client = Client::findOrFail($id);
        if (!$client) {
            return redirect()->route('clients')->with('error', 'Cliente não encontrado.');
        }
    
        // Passa o cliente para a view
        return view('clients.detalhes', compact('client'));  // Passando o cliente completo
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

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $client = Client::with('charges')->find($id);
        if (!$client) {
            return redirect()->route('clients')->with('error', 'Cliente não encontrado.');
        }

        return view('clients.show', [
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

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
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
