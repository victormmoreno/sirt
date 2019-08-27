<?php

namespace App\Repositories\Repository;

use App\Models\Laboratorio;
use App\Models\LineaTecnologica;
use App\Models\Nodo;

class LaboratorioRepository
{
    /**
     * Create a new user and assign default customer role to it.
     *
     * @throws \Exception
     *
     * @param array $params
     * @return Laboratorio
     */
    public function create($params)
    {
        /** @var laboratorio $user */

        try {
            $laboratorio = Laboratorio::forceCreate($this->formatParams($params));
            return true;
        } catch (\Exception $e) {
            //delete laboratorio if there were any errors creating/assigning
            $laboratorio->delete();
            return false;
        }
    }

    /**
     * Prepare given params for inserting into database.
     *
     * @param array $params
     * @param string $type
     * @return array
     */
    protected function formatParams($params, $type = 'create')
    {

        $formatted = [
            'nodo_id'              => isset($params['txtnodo']) ? $params['txtnodo'] : Nodo::NodoFirst()->id,
            'lineatecnologica_id'  => isset($params['txtlinea']) ? $params['txtlinea'] : LineaTecnologica::LineaTecnologicaFirst()->id,
            'nombre'               => $params['txtnombre'],
            'participacion_costos' => isset($params['txtcostos']) ? $params['txtcostos'] : 0,
            'estado'               => isset($params['estado']) ? $params['estado'] : Laboratorio::IsActive(),
        ];

        return $formatted;
    }

    /**
     * devolver consulta laboratorios por nodo.
     *
     * @param int $nodo
     * @return array
     */

    public function findLaboratorioForNodo($nodo)
    {
        return Laboratorio::LaboratorioWithRelations(['lineatecnologica' => function ($query) {
            $query->select('id','abreviatura', 'nombre');
        }])->select('id', 'nodo_id', 'lineatecnologica_id', 'nombre', 'participacion_costos', 'estado')
            ->whereHas('nodo', function ($query) use ($nodo) {
                $query->where('id', $nodo);
            })->get();
    }

}
