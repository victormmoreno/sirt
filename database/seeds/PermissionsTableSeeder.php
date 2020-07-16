<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect(config('laravelpermission.permissions'))
            ->where('callable', true)
            ->each(function ($permissions) {
                Permission::create(['name' => $permissions['name']]);
            });
    }
}
