<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Exibe o formulário de registro.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Processa o registro do novo usuário.
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required'      => 'O nome é obrigatório.',
            'email.required'     => 'O e-mail é obrigatório.',
            'email.unique'       => 'Este e-mail já está em uso.',
            'password.required'  => 'A senha é obrigatória.',
            'password.min'       => 'A senha deve ter ao menos 8 caracteres.',
            'password.confirmed' => 'As senhas não conferem.',
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('success', 'Conta criada com sucesso! Bem-vindo(a), ' . $user->name . '.');
    }
}
