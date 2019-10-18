<?php

use Illuminate\Database\Seeder;
use App\Models\Medida;

class MedidasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Medida::class, 10)->create();
    }
}
