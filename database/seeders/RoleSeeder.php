<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar role de proprietário
        $proprietario = Role::create(['name' => 'proprietario']);

        // Criar permissions
        $permissions = [
            // Clientes
            'clientes.view' => 'Visualizar clientes',
            'clientes.create' => 'Criar clientes',
            'clientes.edit' => 'Editar clientes',
            'clientes.delete' => 'Excluir clientes',

            // Ordens de Serviço
            'ordens.view' => 'Visualizar ordens de serviço',
            'ordens.create' => 'Criar ordens de serviço',
            'ordens.edit' => 'Editar ordens de serviço',
            'ordens.delete' => 'Excluir ordens de serviço',
            'ordens.executar' => 'Executar consertos',
            'ordens.finalizar' => 'Finalizar consertos',

            // Orçamentos
            'orcamentos.view' => 'Visualizar orçamentos',
            'orcamentos.create' => 'Criar orçamentos',
            'orcamentos.edit' => 'Editar orçamentos',
            'orcamentos.delete' => 'Excluir orçamentos',
            'orcamentos.aprovar' => 'Aprovar orçamentos',

            // Relatórios
            'relatorios.view' => 'Visualizar relatórios',
            'relatorios.export' => 'Exportar relatórios',

            // Configurações
            'configuracoes.view' => 'Visualizar configurações',
            'configuracoes.edit' => 'Editar configurações',
        ];

        foreach ($permissions as $name => $description) {
            Permission::create([
                'name' => $name,
                'guard_name' => 'web',
            ]);
        }

        // Atribuir todas as permissions ao proprietário
        $proprietario->givePermissionTo(Permission::all());
    }
}
