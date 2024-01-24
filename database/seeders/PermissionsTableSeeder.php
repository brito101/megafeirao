<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->insert([
            [
                'name' => 'Listar Perfis',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Cadastrar Perfis',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Editar Perfis',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Remover Perfis',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Listar Permissões',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Cadastrar Permissões',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Editar Permissões',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Remover Permissões',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Atribuir Permissões',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Listar Empresas',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Cadastrar Empresas',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Editar Empresas',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Remover Empresas',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Listar Contratos',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Cadastrar Contratos',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Editar Contratos',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Remover Contratos',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Listar Veículos',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Cadastrar Veículos',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Editar Veículos',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Remover Veículos',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Listar Usuários',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Cadastrar Usuários',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Editar Usuários',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Remover Usuários',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Listar Usuários - Equipe',
                'guard_name' => 'web',
            ],
        ]);
    }
}
