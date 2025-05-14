<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function register()
    {
        return view('register');
    }

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

    public function storeStepOne(Request $request)
    {
        // Validação básica
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if (User::where('email', $request->email)->exists()) {
            // Laravel vai automaticamente retornar o erro para a view associada
            return back()->withErrors(['email' => 'Este e-mail já está cadastrado.']);
        }

        // Salva os dados na sessão
        session([
            'name' => $request->name,
            'email' => $request->email
        ]);

    return redirect()->route('password');
    }

   public function finalRegister(Request $request)
{
    $password = $request->input('password');
    $passwordConfirmation = $request->input('password_confirmation');

    // Validação manual
    if (strlen($password) < 6) {
        return back()->withErrors(['password' => 'A senha deve ter pelo menos 6 caracteres.'])->withInput();
    }

    if ($password !== $passwordConfirmation) {
        return back()->withErrors(['password_confirmation' => 'As senhas não coincidem.'])->withInput();
    }

    $name = session()->get('name');
    $email = session()->get('email');

    if (!$name || !$email) {
        return redirect()->route('register')->withErrors([
            'message' => 'Por favor, preencha os dados iniciais de registro.'
        ]);
    }

    $user = User::create([
        'name' => $name,
        'email' => $email,
        'password' => Hash::make($password),
    ]);

    Auth::login($user);
    session()->forget(['name', 'email']);

    return redirect()->route('confirm-register')->with('success', 'Registro completo. Você está autenticado.');
}

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

    public function edit(string $id)
    {
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
        $formattedCpf = $this->formatCpf($validated['cpf'] ?? $user->cpf);
        $formattedPhone = $this->formatPhone($validated['phone'] ?? $user->phone);
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'cpf' => !empty($validated['cpf']) ? $formattedCpf : $user->cpf, // Formata CPF
            'phone' => !empty($validated['phone']) ? $formattedPhone : $user->phone, // Formata telefone
            'password' => $validated['password'] ? bcrypt($validated['password']) : $user->password, // Atualiza senha se fornecida
        ]);
    
        return redirect()->route('home')->with('success', 'Cadastro atualizado com sucesso!');
    }


    
}
