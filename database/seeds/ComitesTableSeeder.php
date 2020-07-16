<?php

use App\Models\Comite;
use Illuminate\Database\Seeder;

class ComitesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Comite::class, 50)->create();
    }
}
