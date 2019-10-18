<?php

use Illuminate\Database\Seeder;
use App\Models\CategoriaMaterial;

class CategoriaMaterialTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(CategoriaMaterial::class, 20)->create();
    }
}
