<?php

use Illuminate\Database\Seeder;
use App\Models\Presentacion;

class PresentacionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Presentacion::class, 8)->create();
    }
}
