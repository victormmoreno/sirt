<?php

use Illuminate\Database\Seeder;
use App\Models\Material;

class MaterialesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Material::class, 50)->create();
    }
}
