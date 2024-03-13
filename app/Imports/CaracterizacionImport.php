<?php

namespace App\Imports;

use App\Models\{Proyecto, Tag};
use App\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\{DB};
use Maatwebsite\Excel\Concerns\ToCollection;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\{WithHeadingRow};
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use PhpOffice\PhpSpreadsheet\Shared\Date;

// HeadingRowFormatter::default('slug');

class CaracterizacionImport implements ToCollection, WithHeadingRow
{
    public $session;
    public $ideaRepository;
    public $validaciones;
    public $hoja = 'Caracterización';

    public function __construct()
    {
        $this->session = session()->get('login_role');
        $this->validaciones = new ValidacionesImport;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        DB::beginTransaction();
        $validacion = null;
        $tags = Tag::ActiveTagsByType(Proyecto::class)->get();
        // dd(str_slug($tags->name));
        // $carbon = new Carbon();
        try {
   
            foreach ($rows as $key => $row) {
                $selected_tags = [];
                // dd($row['convergencia-regional']);
                foreach ($tags as $tag) {
                    if ($row[str_slug($tag->name, '_')] != null) {
                        $selected_tags[] = $tag->id;
                    }
                }
                $selected_tags = Tag::whereIn('id', $selected_tags)->pluck('id');
                // Validar linea
                $proyecto = Proyecto::where('codigo_proyecto', $row['codigo_del_proyecto'])->first();
                $validacion = $this->validaciones->validarQuery($proyecto, $row['codigo_del_proyecto'], $key, 'Código del Proyecto', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }
                $proyecto->tags()->sync($selected_tags);
            }
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            session()->put('errorMigracion', $th->getMessage());
            return false;
        }
    }

}
