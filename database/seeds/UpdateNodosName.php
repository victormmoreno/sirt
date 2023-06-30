<?php

use Illuminate\Database\Seeder;

class UpdateNodosName extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Cambiando nombres de nodos...');
        DB::beginTransaction();
        try {
            DB::table('entidades')
            ->where('id', DB::table('nodos')->select('entidades.id')->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')->where('entidades.nombre', 'Manizales')->first()->id)
            ->update(['nombre' => 'Caldas']);
            DB::table('entidades')
            ->where('id', DB::table('nodos')->select('entidades.id')->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')->where('entidades.nombre', 'Popayán')->first()->id)
            ->update(['nombre' => 'Cauca']);
            DB::table('entidades')
            ->where('id', DB::table('nodos')->select('entidades.id')->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')->where('entidades.nombre', 'Valledupar')->first()->id)
            ->update(['nombre' => 'Cesar']);
            DB::table('entidades')
            ->where('id', DB::table('nodos')->select('entidades.id')->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')->where('entidades.nombre', 'Cazuca')->first()->id)
            ->update(['nombre' => 'Cundinamarca']);
            DB::table('entidades')
            ->where('id', DB::table('nodos')->select('entidades.id')->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')->where('entidades.nombre', 'Pereira')->first()->id)
            ->update(['nombre' => 'Risaralda']);
            DB::table('entidades')
            ->where('id', DB::table('nodos')->select('entidades.id')->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')->where('entidades.nombre', 'Cali')->first()->id)
            ->update(['nombre' => 'Valle']);
            DB::table('entidades')
            ->where('id', DB::table('nodos')->select('entidades.id')->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')->where('entidades.nombre', 'La Granja')->first()->id)
            ->update(['nombre' => 'Tolima']);
            $this->command->info('Nombres cambiados con éxito');
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            $this->command->error('Error: '. $ex->getMessage());
        }
    }
}
