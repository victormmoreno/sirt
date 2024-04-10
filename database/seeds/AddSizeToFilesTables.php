<?php

use Illuminate\Database\Seeder;
use App\Models\{RutaModel, ArchivoModel};
use Illuminate\Support\Facades\Storage;

class AddSizeToFilesTables extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        try {
            $archivos_model = ArchivoModel::all();
            $rutas_model = RutaModel::all();
            Log::channel('seeder')->info('[----------------------------------Actualizando el tamaño de los archivos----------------------------------]'); 
            foreach ($archivos_model as $key => $archivo_model) {
                $path = str_replace('storage', 'public', $archivo_model->ruta);
                $exists = Storage::exists($path);
                if ($exists) {
                    $size = Storage::size($path);
                    Log::channel('seeder')->info($path . ' Filesize: ' . $size);
                    $archivo_model->update([
                        'filesize' => $size
                    ]);
                } else { 
                    Log::channel('seeder')->info($archivo_model->id . '#No hay archivo en la ruta ' . $path);
                }
            }
            
            foreach ($rutas_model as $key => $ruta_model) {
                $path = str_replace('storage', 'public', $ruta_model->ruta);
                $exists = Storage::exists($path);
                if ($exists) {
                    $size = Storage::size($path);
                    Log::channel('seeder')->info($path . ' Filesize: ' . $size);
                    $ruta_model->update([
                        'filesize' => $size
                    ]);
                } else { 
                    Log::channel('seeder')->info($ruta_model->id . '#No hay archivo en la ruta ' . $path);
                }
            }
            Log::channel('seeder')->info('[----------------------------------Fin de la actualización del tamaño de los archivos----------------------------------]'); 
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::channel('seeder')->info('Error: ' . $th->getMessage());
            $this->command->error('Error: ' . $th->getMessage());
            throw $th;
        }
    }

}
