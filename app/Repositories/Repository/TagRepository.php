<?php

namespace App\Repositories\Repository;


use App\Models\{Tag};
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Repositories\Repository\Repository;

class TagRepository extends Repository
{
    /**
     * Cambiar el estado a habilitado/inhabilitado de un etiqueta
     * @param Request $tag Id de la tag
     * @param Request $tag Id de la tag
     * @return boolean
     * @author dum
     */
    public function update_state($tag, $state)
    {
        DB::beginTransaction();
        try {
            $tag = Tag::findOrFail($tag);
            $tag->update([
                'state' => $state
            ]);

            DB::commit();
            return [
                'state' => true,
                'msg' => 'La etiqueta se ha cambiado de estado',
                'title' => 'Registro exitoso',
                'type' => 'success'
            ];
        } catch (\Exception $e) {
            DB::rollback();
            return [
                'state' => false,
                'msg' => 'No se ha cambiado el estado de la etiqueta: '. $e->getMessage(),
                'title' => 'Registro erróneo',
                'type' => 'error'
            ];
        }
    }

    /**
     * Registra un nuevo proyecto en la base de datos
     * @param Request $request Datos del formulario
     * @return array
     * @author dum
     */
    public function store($request)
    {
        DB::beginTransaction();
        try {
            $tag = Tag::create([
                'name' => $request->txtTag,
                'description' => $request->txtDescription,
                'type' => $request->selectType,
                'slug' => Str::slug(class_basename($request->selectType).' '.$request->txtTag, '-'),
                'state' => Tag::IsActive()
            ]);

            DB::commit();
            return [
                'state' => true,
                'msg' => 'Se ha registrado una nueva etiqueta para ' . class_basename($tag->type),
                'title' => 'Registro exitoso',
                'type' => 'success',
                'url' => route('tag.index')
            ];
        } catch (\Exception $e) {
            DB::rollback();
            return [
                'state' => false,
                'msg' => 'No se ha registrado la etiqueta: '. $e->getMessage(),
                'title' => 'Registro erróneo',
                'type' => 'error'
            ];
        }
    }

    /**
     * Registra un nuevo proyecto en la base de datos
     * @param Request $request Datos del formulario
     * @return array
     * @author dum
     */
    public function update($request, $tag)
    {
        DB::beginTransaction();
        try {
            $tag->update([
                'name' => $request->txtTag,
                'description' => $request->txtDescription
            ]);

            DB::commit();
            return [
                'state' => true,
                'msg' => 'Se ha cambiado la información para la etiqueta de ' . class_basename($tag->type),
                'title' => 'Registro exitoso',
                'type' => 'success',
                'url' => route('tag.index')
            ];
        } catch (\Exception $e) {
            DB::rollback();
            return [
                'state' => false,
                'msg' => 'No se ha cambiado la información de la etiqueta: '. $e->getMessage(),
                'title' => 'Registro erróneo',
                'type' => 'error'
            ];
        }
    }
}
