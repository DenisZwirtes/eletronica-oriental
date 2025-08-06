<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return Inertia::render('Auth/Register');
    }

    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        // Criar o usuário
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Atribuir a role 'proprietario' ao usuário
        $proprietarioRole = Role::where('name', 'proprietario')->first();
        if ($proprietarioRole) {
            $user->assignRole($proprietarioRole);
        }

        // Fazer login automaticamente
        Auth::login($user);

        // Redirecionar para o dashboard
        return redirect()->intended('/dashboard');
    }
}
