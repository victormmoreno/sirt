<?php

use App\Models\Support;
use Illuminate\Database\Seeder;

class SupportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Support::class, 100)->create();
    }
}
