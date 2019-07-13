<?php

use App\Models\ContactoEntidad;
use Illuminate\Database\Seeder;

class ContactosEntidadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ContactoEntidad::class, 35)->create();
    }
}
