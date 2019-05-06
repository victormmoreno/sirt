<?php

use App\Models\Departamento;
use Illuminate\Database\Seeder;

class DepartamentosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Departamento::create([
            'id'     => 1,
            'nombre' => 'Amazonas',
        ]);

        Departamento::create([
            'id'     => 2,
            'nombre' => 'Antioquia',
        ]);

        Departamento::create([
            'id'     => 3,
            'nombre' => 'Arauca',
        ]);

        Departamento::create([
            'id'     => 4,
            'nombre' => 'Atlántico',
        ]);

        Departamento::create([
            'id'     => 5,
            'nombre' => 'Bolívar',
        ]);

        Departamento::create([
            'id'     => 6,
            'nombre' => 'Boyacá',
        ]);

        Departamento::create([
            'id'     => 7,
            'nombre' => 'Caldas',
        ]);

        Departamento::create([
            'id'     => 8,
            'nombre' => 'Caquetá',
        ]);

        Departamento::create([
            'id'     => 9,
            'nombre' => 'Casanare',
        ]);

        Departamento::create([
            'id'     => 10,
            'nombre' => 'Cauca',
        ]);

        Departamento::create([
            'id'     => 11,
            'nombre' => 'Cesar',
        ]);

        Departamento::create([
            'id'     => 12,
            'nombre' => 'Chocó',
        ]);

        Departamento::create([
            'id'     => 13,
            'nombre' => 'Córdoba',
        ]);

        Departamento::create([
            'id'     => 14,
            'nombre' => 'Cundinamarca',
        ]);

        Departamento::create([
            'id'     => 15,
            'nombre' => 'Güainia',
        ]);

        Departamento::create([
            'id'     => 16,
            'nombre' => 'Guaviare',
        ]);

        Departamento::create([
            'id'     => 17,
            'nombre' => 'Huila',
        ]);

        Departamento::create([
            'id'     => 18,
            'nombre' => 'La Guajira',
        ]);

        Departamento::create([
            'id'     => 19,
            'nombre' => 'Magdalena',
        ]);

        Departamento::create([
            'id'     => 20,
            'nombre' => 'Meta',
        ]);

        Departamento::create([
            'id'     => 21,
            'nombre' => 'Nariño',
        ]);

        Departamento::create([
            'id'     => 22,
            'nombre' => 'Norte de Santander',
        ]);

        Departamento::create([
            'id'     => 23,
            'nombre' => 'Putumayo',
        ]);

        Departamento::create([
            'id'     => 24,
            'nombre' => 'Quindio',
        ]);

        Departamento::create([
            'id'     => 25,
            'nombre' => 'Risaralda',
        ]);

        Departamento::create([
            'id'     => 26,
            'nombre' => 'San Andrés y Providencia',
        ]);

        Departamento::create([
            'id'     => 27,
            'nombre' => 'Santander',
        ]);

        Departamento::create([
            'id'     => 28,
            'nombre' => 'Sucre',
        ]);

        Departamento::create([
            'id'     => 29,
            'nombre' => 'Tolima',
        ]);

        Departamento::create([
            'id'     => 30,
            'nombre' => 'Valle del Cauca',
        ]);

        Departamento::create([
            'id'     => 31,
            'nombre' => 'Vaupés',
        ]);

        Departamento::create([
            'id'     => 32,
            'nombre' => 'Vichada',
        ]);

        // factory(Departamento::class, 20)->create();
    }
}
