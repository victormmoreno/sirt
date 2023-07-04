<?php

use Illuminate\Database\Seeder;
use App\Models\UsoInfraestructura;

class AddCodigoToUsoInfraestructuraTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        $this->command->info('Generando codigo de asesorias');
        try {
            $asesories = UsoInfraestructura::select(
                'usoinfraestructuras.id', 'usoinfraestructuras.asesorable_type', 'usoinfraestructuras.asesorable_id', 'usoinfraestructuras.codigo','usoinfraestructuras.fecha', 'asesores.id as user_id',
            )
            ->leftJoin('gestor_uso', 'gestor_uso.usoinfraestructura_id', '=', 'usoinfraestructuras.id')
                ->leftJoin('users as asesores', 'asesores.id', '=', 'gestor_uso.asesor_id')
            ->get();
            foreach ($asesories as $key => $asesorie) {
                DB::table('usoinfraestructuras')
                ->where('usoinfraestructuras.id', $asesorie->id)
                ->update(['codigo' => $this->generateCodeAsesorie($asesorie)]);
            }
            DB::commit();
            $this->command->info('Codigo de asesorias generado');
        }catch (\Throwable $th) {
            DB::rollBack();
            $this->command->error('Error: '. $th->getMessage());
            throw $th;
        }
    }

    protected function generateCodeAsesorie($asesorie)
    {
        $initial = 'ASE';
        $year = isset($asesorie->fecha) ? \Carbon\Carbon::parse($asesorie->fecha)->isoFormat('YYYY') : '';
        $month = isset($asesorie->fecha) ? \Carbon\Carbon::parse($asesorie->fecha)->isoFormat('mm') : '';
        $user = isset($asesorie->user_id) ? sprintf("%03d", $asesorie->user_id): '';
        $consecutive =  isset($asesorie->id) ? sprintf("%02d", $asesorie->id): '';
        return "{$initial}{$year}-{$user}{$month}{$user}-{$consecutive}";
    }
}
