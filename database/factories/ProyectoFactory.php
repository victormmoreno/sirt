<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\{Proyecto, Idea, Sector, Sublinea, AreaConocimiento, Fase, EstadoProyecto, TipoArticulacionProyecto, EstadoPrototipo};
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(Proyecto::class, function (Faker $faker) {
    $idea = Idea::all()->random();
    $sector = Sector::all()->random();
    $sublinea = Sublinea::all()->random();
    $areaConocimiento = AreaConocimiento::all()->random();
    $fase = Fase::all()->random();
    $estadoproyecto = EstadoProyecto::all()->random();
    $tipoArticulacionProyecto = TipoArticulacionProyecto::all()->random();
    $estadoPrototipo = EstadoPrototipo::all()->random();
    return [
        'idea_id' => $idea->id,
        'sector_id' => $sector->id,
        'sublinea_id' => $sublinea->id,
        'areaconocimiento_id' => $areaConocimiento->id,
        'fase_id' => $fase->id,
        'estadoproyecto_id' => $estadoproyecto->id,
        'tipoarticulacionproyecto_id' => $tipoArticulacionProyecto->id,
        'estadoprototipo_id' => $estadoPrototipo->id,
        'estado_aprobacion' => $faker->randomElement([1, 0]),
        'tipo_ideaproyecto' => 0,
        'otro_tipoarticulacion' => null,
        'otro_estadoprototipo' => null,
        'otro_areaconocimiento' => null,
        'universidad_proyecto' => null,
        'alcance_proyecto' => null,
        'trl_esperado' => $faker->randomElement([1, 0]),
        'trl_obtenido' => $faker->randomElement([1, 0]),
        'trl_prototipo' => null,
        'trl_pruebas' => null,
        'trl_modelo' => null,
        'trl_normatividad' => null,
        'evidencia_trl' => $faker->randomElement([1, 0]),
        'observaciones_proyecto' => null,
        'dirigido_discapacitados' => $faker->randomElement([1, 0]),
        'tipo_discapacitados' => null,
        'impacto_proyecto' => null,
        'economia_naranja' => $faker->randomElement([1, 0]),
        'tipo_economianaranja' => null,
        'fabrica_productividad' => $faker->randomElement([1, 0]),
        'doc_titular' => $faker->randomElement([1, 0]),
        'resultado_proyecto' => null,
        'fecha_ejecucion' => Carbon::now(),
        'aporte_sena' => null,
        'aporte_talento' => null,
        'cedula_acudiente' => null,
        'nombre_acudiente' => null,
        'art_cti' => $faker->randomElement([1, 0]),
        'nom_act_cti' => null,
        'diri_ar_emp' => $faker->randomElement([1, 0]),
        'reci_ar_emp' => $faker->randomElement([1, 0]),
        'dine_reg' => $faker->randomElement([1, 0]),
        'acc' => $faker->randomElement([1, 0]),
        'manual_uso_inf' => $faker->randomElement([1, 0]),
        'aval_empresa_grupo' => $faker->randomElement([1, 0]),
        'estado_arte' => $faker->randomElement([1, 0]),
        'video_tutorial' => $faker->randomElement([1, 0]),
        'url_videotutorial' => null,
        'ficha_caracterizacion' => $faker->randomElement([1, 0]),
        'lecciones_aprendidas' => $faker->randomElement([1, 0]),
        'encuesta' => $faker->randomElement([1, 0]),

    ];
});
