<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([AdminTableUserSeeder::class]);
        $this->call([RolesTableSeeder::class]);
        $this->call([PermissionsTableSeeder::class]);
        $this->call([ModelHasRoleTableSeeder::class]);
        $this->call([RoleHasPermissionsTableSeeder::class]);
        $this->call([TermsTableSeeder::class]);
    }
}
