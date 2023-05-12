<?php

use Illuminate\Database\Seeder;
use App\Models\{Visitante, IngresoVisitante, Servicio, Nodo};
use Faker\Generator;
use Illuminate\Container\Container;

class VisitantesTableSeeder extends Seeder
{
    /**
     * The current Faker instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Create a new seeder instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    /**
     * Get a new Faker instance.
     *
     * @return \Faker\Generator
     */
    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 30000; $i++) {
            IngresoVisitante::create([
                'user_id' => 457,
                'visitante_id' => rand(34005, 54004),
                'nodo_id' => Nodo::all()->random()->id,
                'servicio_id' => Servicio::all()->random()->id,
                'fecha_ingreso' => $this->faker->dateTimeInInterval('-7 week', '+7 week'),
                'hora_salida' => $this->faker->time,
                'quien_autoriza' => $this->faker->firstName . ' ' . $this->faker->lastName,
                'descripcion' => $this->faker->text($maxNbChars = 200),
            ]);
        }
    }
}
