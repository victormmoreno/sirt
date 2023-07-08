<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\User;

class AddRoleUsuarioToRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::whereIn('name', [User::IsUsuario()])->first();
        if($role == null){
            $this->command->info('Insertando nuevo rol...');
            Role::create([
                'name' => User::IsUsuario(),
                'guard_name' => 'web'
            ]);
            $this->command->info('Nuevo rol insertado...');
        }
    }
}
