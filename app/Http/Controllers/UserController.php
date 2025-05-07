<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function register()
    {
        return view('register');
    }

    /**
     * Display the password reset view.
     */
    public function password()
    {
        return view('password');
    }

    public function confirmation()
    {
        return view('confirm-register');
    }

    public function login()
    {
        return view('login');
    }


    /**
     * Show the form for creating a new user (not directly used in this context).
     */
    public function create()
    {
        //
    }

    /**
     * Store the first step of the registration process.
     */
    public function storeStepOne(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);

        session([
            'name' => $request->name,
            'email' => $request->email
        ]);

        return redirect()->route('password');
    }

    /**
     * Finalize the registration process and create a new user.
     */
    public function finalRegister(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);
    
        // Recuperar os dados da sessão (nome e e-mail)
        $name = session()->get('name');
        $email = session()->get('email');
    
        // Verificar se os dados da primeira etapa ainda estão na sessão
        if (!$name || !$email) {
            return redirect()->route('register')->withErrors(['message' => 'Por favor, preencha os dados iniciais de registro.']);
        }
    
        // Criar o usuário com os dados coletados
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($request->password),  // Hash para segurança
        ]);
    
        // Fazer login automaticamente após o registro
        Auth::login($user);
    
        // Limpar os dados da sessão
        session()->forget('name');
        session()->forget('email');
    
        // Redirecionar para a página de confirmação ou outra página desejada
        return redirect()->route('confirm-register')->with('success', 'Registro completo. Você está autenticado.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Buscar o usuário
        $user = User::findOrFail($id);
    
        // Formatar o CPF e o telefone do usuário
        $user->cpf = $this->formatCpf($user->cpf);
        $user->phone = $this->formatPhone($user->phone);
    
        // Passar o usuário para a view
        return view('user.edit', compact('user'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validações
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'cpf' => 'nullable|string|unique:users,cpf,' . $id,  // Permitindo CPF nulo, mas se não for nulo, precisa ser único
            'phone' => 'nullable|string|unique:users,phone,' . $id,  // Permitindo telefone nulo, mas se não for, precisa ser único
            'password' => 'nullable|string|min:6|confirmed',  // Senha opcional se não for modificada
        ]);
    
        $user = User::findOrFail($id);

        // Formatação de CPF e Telefone
        $formattedCpf = $this->formatCpf($validated['cpf'] ?? $user->cpf);
        $formattedPhone = $this->formatPhone($validated['phone'] ?? $user->phone);
    
        // Lógica de atualização do usuário
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'cpf' => !empty($validated['cpf']) ? $formattedCpf : $user->cpf, // Formata CPF
            'phone' => !empty($validated['phone']) ? $formattedPhone : $user->phone, // Formata telefone
            'password' => $validated['password'] ? bcrypt($validated['password']) : $user->password, // Atualiza senha se fornecida
        ]);
    
        return redirect()->route('home')->with('success', 'Cadastro atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Função para formatar CPF
     */
    private function formatCpf($cpf)
    {
        $cpf = preg_replace('/\D/', '', $cpf); // Remove tudo o que não for número
        if (strlen($cpf) === 11) { // Verifica se o CPF tem 11 dígitos
            return substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
        }
        return $cpf; // Retorna o CPF sem formatação se não tiver 11 dígitos
    }
    
    private function formatPhone($phone)
    {
        $phone = preg_replace('/\D/', '', $phone); // Remove tudo o que não for número
        if (strlen($phone) === 11) { // Verifica se o telefone tem 11 dígitos
            return '(' . substr($phone, 0, 2) . ') ' . substr($phone, 2, 5) . '-' . substr($phone, 7, 4);
        }
        return $phone; // Retorna o telefone sem formatação se não tiver 11 dígitos
    }
    
}
