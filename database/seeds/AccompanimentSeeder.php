<?php

use Illuminate\Database\Seeder;
use App\Models\Accompaniment;

class AccompanimentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Accompaniment::class, 40)->create()->each(function($accompaniment){

        });
    }
}
