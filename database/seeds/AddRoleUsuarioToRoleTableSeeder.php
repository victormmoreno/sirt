<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class AddRoleUsuarioToRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Usuario',
            'guard_name' => 'web'
        ]);
    }
}
