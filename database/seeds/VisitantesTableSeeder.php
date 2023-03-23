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
        //factory(Visitante::class, 10000)->create();
        // factory(IngresoVisitante::class, 20000)->create()->each(function ($ingreso) {
        //     $ingreso->save(factory(IngresoVisitante::class)->make());
        // });
        // factory(IngresoVisitante::class, 5000)->create();
        // $faker = new Faker;
        for ($i=0; $i < 1000; $i++) {
            IngresoVisitante::create([
                'user_id' => 457,
                'visitante_id' => rand(64456, 74455),
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
