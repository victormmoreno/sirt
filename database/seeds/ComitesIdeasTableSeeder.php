<?php

use App\Models\ComiteIdea;
use Illuminate\Database\Seeder;
use Lcobucci\JWT\Claim;

class ComitesIdeasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ComiteIdea::class, 100)->create();
    }
}
