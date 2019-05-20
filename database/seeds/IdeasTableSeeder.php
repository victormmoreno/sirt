<?php

use Illuminate\Database\Seeder;
use App\Models\Idea;

class IdeasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Idea::class, 20)->create();
    }
}
