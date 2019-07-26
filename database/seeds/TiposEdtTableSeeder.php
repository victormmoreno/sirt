<?php

use Illuminate\Database\Seeder;
use App\Models\TipoEdt;

class TiposEdtTableSeeder extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()
  {
    TipoEdt::create([
      'nombre' => 'Tipo 1',
      'observaciones' => 'Evento que fomenta las capacidades de innovación, vigilancia tecnológica, creatividad, design  thinking,  capacidad  técnica,
      dictado  por  un  gestor.  Para  mínimo  20  personas,  una duración 4 horas.'
    ]);

    TipoEdt::create([
      'nombre' => 'Tipo 2',
      'observaciones' => 'Eventosobre la socialización de tecnologías y equipos nuevos o procesos innovadores,
      dictado por gestores Tecnoparques, expertos externos o con varios expositores, para mínimo 20 personas, una duración de 4 horas.'
    ]);

    TipoEdt::create([
      'nombre' => 'Tipo 3',
      'observaciones' => 'Eventomasivo  para  fomentar  la  innovación,  la  apropiación  del  conocimiento  y  la tecnología,
      organizado con varios ponentes, en la figura de  congreso, simposio o seminario. Para mínimo 50 personas, una duración de 8 horas.'
    ]);
  }
}
