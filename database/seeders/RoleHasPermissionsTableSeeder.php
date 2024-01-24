<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class RoleHasPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = Permission::all();

        foreach ($permissions as $permission) {
            DB::table('role_has_permissions')->insert(
                [
                    'permission_id' => $permission->id,
                    'role_id' => 1
                ],
            );
        }
    }
}
