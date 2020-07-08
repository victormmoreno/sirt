<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => config('laravelpermission.roles.roleAdministrador'),
        ]);
        Role::create([
            'name' => config('laravelpermission.roles.roleDinamizador'),
        ]);
        Role::create([
            'name' => config('laravelpermission.roles.roleGestor'),
        ]);
        Role::create([
            'name' => config('laravelpermission.roles.roleInfocenter'),
        ]);
        Role::create([
            'name' => config('laravelpermission.roles.roleTalento'),
        ]);
        Role::create([
            'name' => config('laravelpermission.roles.roleIngreso'),
        ]);
        Role::create([
            'name' => config('laravelpermission.roles.roleDesarrollador'),
        ]);
    }
}
