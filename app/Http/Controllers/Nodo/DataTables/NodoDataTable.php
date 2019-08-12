<?php

namespace App\Http\Controllers\Nodo\DataTables;

use App\Models\Nodo;
use App\User;
use Repositories\Repository\NodoRepository;
use Yajra\DataTables\Services\DataTable;

class NodoDataTable extends DataTable
{

    public $nodoRepository;

    public function __construct(NodoRepository $nodoRepository)
    {

        $this->nodoRepository = $nodoRepository;

    }
    /**
     * Build DataTable class.
     *
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable()
    {
        return datatables()
            ->eloquent($this->query())
            ->addColumn('action', 'ffas');
    }
    // public function ajax()
    // {
    //     return $this->datatables
    //         ->eloquent($this->query())
    //         ->make(true);
    // }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = User::select('id', 'nombres', 'created_at', 'updated_at');

        return $this->applyScopes($query);
    }

    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->parameters([
                'dom'     => 'Bfrtip',
                'buttons' => ['export', 'print', 'reset', 'reload'],
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id',
            'nombres',
            'created_at',
            'updated_at',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'posts_' . time();
    }
    //
    // public function dataTable()
    // {
    //     return datatables()
    //         ->eloquent($this->query())
    //         ->addColumn('action', 'path.to.action.view');
    // }

    // public function query()
    // {
    //     $query = Nodo::select('entidades.id', DB::raw("CONCAT('Tecnoparque Nodo ',entidades.nombre) as nodos"), "nodos.direccion", DB::raw("CONCAT(centros.codigo_centro,' -  ',ent.nombre) as centro"), DB::raw("CONCAT(ciudades.nombre,' (',departamentos.nombre,') ') as ubicacion"))
    //         ->join('centros', 'centros.id', '=', 'nodos.centro_id')
    //         ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
    //         ->join('entidades as ent', 'ent.id', '=', 'centros.entidad_id')
    //         ->join('ciudades', 'ciudades.id', '=', 'entidades.ciudad_id')
    //         ->join('departamentos', 'departamentos.id', '=', 'ciudades.departamento_id');

    //     return $this->applyScopes($query);
    // }

    //  public function html()
    // {
    //     return $this->builder()
    //                 ->columns($this->getColumns())
    //                 ->parameters([
    //                     'buttons' => ['csv'],
    //                 ]);
    // }

    // protected function getColumns()
    // {
    //     return [
    //         'id',
    //         'nombres',
    //         'created_at',
    //         'updated_at',
    //     ];
    // }
}
