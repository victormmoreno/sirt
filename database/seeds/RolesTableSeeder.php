<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleAdmin = Role::create([
            'name' => config('laravelpermission.roles.roleAdministrador'),
        ]);



        $roleDinamizador = Role::create([
            'name' => config('laravelpermission.roles.roleDinamizador'),
        ]);
        $roleGestor = Role::create([
            'name' => config('laravelpermission.roles.roleGestor'),
        ]);
        $roleInfocenter = Role::create([
            'name' => config('laravelpermission.roles.roleInfocenter'),
        ]);
        $roleInfocenter->givePermissionTo(Permission::findByName('leer ideas'));
        $roleInfocenter->givePermissionTo(Permission::findByName('Registrar ideas'));
        $roleInfocenter->givePermissionTo(Permission::findByName('Editar ideas'));
        $roleInfocenter->givePermissionTo(Permission::findByName('Eliminar ideas'));
        $roleTalento = Role::create([
            'name' => config('laravelpermission.roles.roleTalento'),
        ]);
        $roleIngreso = Role::create([
            'name' => config('laravelpermission.roles.roleIngreso'),
        ]);
        $roleDesarrollador = Role::create([
            'name' => config('laravelpermission.roles.roleDesarrollador'),
        ]);
    }
}
