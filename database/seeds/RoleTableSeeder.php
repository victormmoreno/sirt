<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $roleAdministrador = Role::create(['name' => 'Administrador']);
        $roleDinamizador = Role::create(['name' => 'Dinamizador']);
        $roleGestor = Role::create(['name' => 'Gestor']);
        $roleInfocenter = Role::create(['name' => 'Infocenter']);
        $roleTalento = Role::create(['name' => 'Talento']);
        $roleIngreso = Role::create(['name' => 'Ingreso']);
        $roleProveedor = Role::create(['name' => 'Proveedor']);
    }
}
