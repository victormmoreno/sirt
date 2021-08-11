<?php

namespace App\Repositories\Repository;

use Illuminate\Support\Facades\DB;
use App\Models\{Publicacion};
use Carbon\Carbon;

class PublicacionRepository
{
    /**
     * Modifica los datos de un publicación
     *
     * @param Request $request
     * @param int $id Id de la publicación
     * @return boolean
     * @author dum
     */
    public function update($request, int $id)
    {
        DB::beginTransaction();
        try {
            $publicacion = Publicacion::find($id);
            $publicacion->update([
                'role_id' => $request->txtrole_id,
                'titulo' => $request->txttitulo,
                'contenido' => $request->txtcontenido,
                'fecha_inicio' => $request->txtfecha_inicio,
                'fecha_fin' => $request->txtfecha_fin
            ]);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    /**
     * Cambia el estado de la publicación
     *
     * @param int $id Id de la publicación
     * @param int $estado Estado
     * @return boolean
     * @author dum
     */
    public function updateEstado($id, $estado)
    {
        DB::beginTransaction();
        try {
            $publicacion = Publicacion::find($id);
            $publicacion->update(['estado' => $estado]);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    /**
     * Consulta una publicacion por el código
     *
     * @param string $codigo Código de la publicación
     * @return Builder
     */
    public function buscarPublicacionPorCodigo($codigo)
    {
        return Publicacion::where('codigo_publicacion', $codigo);
    }

    /**
     * Query generico para de las publicaciones
     *
     * @return Builder
     * @author dum
     */
    public function consultarPublicaciones()
    {
        return Publicacion::select('codigo_publicacion', 'fecha_inicio', 'fecha_fin', 'titulo', 'contenido', 'publicaciones.estado', 'roles.name AS role', 'publicaciones.id', 'role_id')
        ->join('users', 'users.id', '=', 'publicaciones.user_id')
        ->join('roles', 'roles.id', '=', 'publicaciones.role_id');
    }

    /**
     * Registra la publicación en la base de datos
     *
     * @param Request $request
     * @return boolean
     */
    public function store($request)
    {
        $codigo = $this->generarCodigoPublicacion($request->txtfecha_inicio, $request->txtrole_id);
        Publicacion::create([
            'user_id' => auth()->user()->id,
            'role_id' => $request->txtrole_id,
            'titulo' => $request->txttitulo,
            'codigo_publicacion' => $codigo,
            'contenido' => $request->txtcontenido,
            'fecha_inicio' => $request->txtfecha_inicio,
            'fecha_fin' => $request->txtfecha_fin,
            'estado' => Publicacion::IsActiva()
        ]);
        DB::beginTransaction();
        try {
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }

    }

    /**
     * Genera un código para la publicación
     *
     * @param type var Description
     * @return string
     * @author dum
     */
    private function generarCodigoPublicacion($fecha_inicio, $role_id)
    {
        $fecha_inicio = Carbon::parse($fecha_inicio);
        $anho = Carbon::now()->isoFormat('YYYY');
        $month = $fecha_inicio->isoFormat('MM');
        $day = $fecha_inicio->isoFormat('DD');
        $id = $this->getMaxIdPublicacion();
        $rol = $this->getRoleId($role_id);
        $codigo = 'N' . $anho . '-' . $month . $day . $rol . '-' . $id;
        return $codigo;
    }

    /**
     * Retorna el id del rol al que se le mostrará la publicación
     *
     * @param int $rol
     * @return string
     * @author dum
     */
    private function getRoleId($rol)
    {
        $rol = sprintf("%02d", $rol);
        return $rol;
    }

    /**
     * Retorna el máximo id de publicaciones
     *
     * @return string
     * @author dum
     */
    private function getMaxIdPublicacion()
    {
        $id = Publicacion::selectRaw('MAX(id+1) AS max')->get()->last();
        if ($id->max == null) {
        $id = 1;
        } else {
        $id = $id->max;
        }
        $id = sprintf("%03d", $id);
        return $id;
    }
}
