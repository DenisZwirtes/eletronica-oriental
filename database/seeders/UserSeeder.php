<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar usuário proprietário
        $proprietario = User::create([
            'name' => 'Proprietário',
            'email' => 'proprietario@eletronica.com',
            'password' => Hash::make('password'),
            'phone' => '(11) 99999-9999',
            'ativo' => true,
        ]);
        $proprietario->assignRole('proprietario');

        $this->command->info('Usuário proprietário criado com sucesso!');
        $this->command->info('Email: proprietario@eletronica.com');
        $this->command->info('Senha: password');
    }
}
