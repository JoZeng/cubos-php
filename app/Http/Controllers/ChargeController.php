<?php

namespace App\Http\Controllers;

use App\Models\Charge;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ChargeController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->input('search', '');
        $statusFilter = $request->input('status', null); // pega ?status=paga, pendente ou vencida

        // Prepara a consulta com a relação com o cliente
        $chargesQuery = Charge::with('client')->whereHas('client', function ($query) use ($user, $search) {
            $query->where('user_id', $user->id);
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
                      ->orWhere('cpf', 'like', '%' . $search . '%');
                });
            }
        });

        // Filtra por status se informado
        if (!empty($statusFilter)) {
            $chargesQuery->where(function ($q) use ($statusFilter) {
                if ($statusFilter === 'vencida') {
                    $q->where('status', 'pendente')->where('expiration', '<', Carbon::now());
                } elseif ($statusFilter === 'pendente') {
                    $q->where('status', 'pendente')->where('expiration', '>=', Carbon::now());
                } else {
                    $q->where('status', $statusFilter);
                }
            });
        }

        $clients = Client::where('user_id', $user->id)->get();
        $charges = $chargesQuery->paginate(10)->appends([
            'search' => $search,
            'status' => $statusFilter
        ]);

        $charges->getCollection()->transform(function ($charge) {
            if ($charge->status === 'paga') {
                $charge->calculated_status = 'paga';
            } elseif ($charge->status === 'pendente') {
                $charge->calculated_status = Carbon::parse($charge->expiration)->isPast() ? 'vencida' : 'pendente';
            } else {
                $charge->calculated_status = 'desconhecido';
            }
            return $charge;
        });

        return view('charges', [
            'clients' => $clients,
            'charges' => $charges,
            'search' => $search,
            'paginaAtual' => $charges->currentPage(),
            'totalPaginas' => $charges->lastPage(),
            'user' => $user,
            'statusFilter' => $statusFilter,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'expiration' => 'required|date_format:d/m/Y',
            'value' => 'required|numeric',
            'status' => 'required|in:paga,pendente',
            'client_id' => 'required|exists:clients,id'
        ]);

        $expiration = \DateTime::createFromFormat('d/m/Y', $request->expiration);
        if (!$expiration) {
            return back()->withErrors(['expiration' => 'Data de vencimento inválida.']);
        }

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
        $charges = Charge::where('client_id', $clientId)->get();

        $totalPendente = $charges->where('status', 'pendente')->sum('value');
        $totalPago = $charges->where('status', 'paga')->sum('value');

        $status = $totalPendente > $totalPago ? 'inadimplente' : 'em dia';

        return view('clientes.detalhes', compact('clientId', 'status', 'totalPendente', 'totalPago'));
    }

    public function create()
    {
        $user = auth()->user();

        if (!$user->cliente) {
            return redirect()->route('clients')->with('error', 'Usuário não possui cliente associado.');
        }

        $client_id = $user->cliente->id;

        return view('components.modals.modal-charges-add', compact('client_id'));
    }

public function show($id)
{
    $client = Client::findOrFail($id);
    $charges = Charge::where('client_id', $id)->with('client')->get();

    $charges->transform(function ($charge) {
        if ($charge->status === 'paga') {
            $charge->calculated_status = 'paga';
        } elseif ($charge->status === 'pendente') {
            $charge->calculated_status = Carbon::parse($charge->expiration)->isPast() ? 'vencida' : 'pendente';
        } else {
            $charge->calculated_status = 'desconhecido';
        }
        return $charge;
    });

    return view('charges.show', compact('client', 'charges'));
}


    public function destroy($id)
    {
        $charge = Charge::findOrFail($id);
        if ($charge) {
            $charge->delete();
            return redirect()->back()->with('success', 'Cobrança excluída com sucesso!');
        }
        return redirect()->back()->with('error', 'Cobrança não encontrada.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'expiration' => 'required|date_format:d/m/Y',
            'value' => 'required|numeric|min:0',
            'status' => 'required|in:pendente,paga',
        ]);

        $charge = Charge::findOrFail($id);

        $charge->description = $request->description;
        $charge->expiration = Carbon::createFromFormat('d/m/Y', $request->expiration)->format('Y-m-d');
        $charge->value = $request->value;
        $charge->status = $request->status;

        $charge->save();

        return redirect()->route('charges')->with('success', 'Cobrança atualizada com sucesso!');
    }
    public function updateCharges(Request $request, $chargeId)
{
    $request->validate([
        'description' => 'required|string|max:255',
        'expiration' => 'required|date_format:d/m/Y',
        'value' => 'required|numeric|min:0',
        'status' => 'required|in:pendente,paga',
    ]);

    $charge = Charge::findOrFail($chargeId);
    $charge->description = $request->description;
    $charge->expiration = Carbon::createFromFormat('d/m/Y', $request->expiration)->format('Y-m-d');
    $charge->value = $request->value;
    $charge->status = $request->status;
    $charge->save();

    return redirect()->back()->with('success', 'Cobrança atualizada com sucesso!');
}    
}
