<?php

namespace App\Repositories\Datatables;
use Illuminate\Support\{Str};
use App\User;
class UserDatatables
{
    
    public function datatableUsers($request, $users)
    {
        return datatables()->of($users)
        ->addColumn('detail', function ($data) {
            $button = '<a href="' . route("usuario.usuarios.show", $data->documento) . '" class=" btn tooltipped green-complement  m-b-xs " data-position="bottom" data-delay="50" data-tooltip="Detalles"><i class="material-icons">visibility</i></a>';
            return $button;
        })
        ->editColumn('celular', function ($data) {
            return !empty($data->celular) ? $data->celular : 'No registra';
        })
        // ->filter(function ($instance) use ($request) {
        //         if (!empty($request->get('tipodocumento'))) {
        //             $instance->collection = $instance->collection->filter(function ($row) use ($request) {
        //                 return Str::contains($row['tipodocumento'], $request->get('tipodocumento')) ? true : false;
        //             });
        //         }
        //         if (!empty($request->get('documento'))) {
        //             $instance->collection = $instance->collection->filter(function ($row) use ($request) {
        //                 return Str::contains($row['documento'], $request->get('documento')) ? true : false;
        //             });
        //         }
        //         if (!empty($request->get('nombre'))) {
        //             $instance->collection = $instance->collection->filter(function ($row) use ($request) {
        //                 return Str::contains($row['nombre'], $request->get('nombre')) ? true : false;
        //             });
        //         }
        //         if (!empty($request->get('email'))) {
        //             $instance->collection = $instance->collection->filter(function ($row) use ($request) {
        //                 return Str::contains($row['email'], $request->get('email')) ? true : false;
        //             });
        //         }
        //         if (!empty($request->get('celular'))) {
        //             $instance->collection = $instance->collection->filter(function ($row) use ($request) {
        //                 return Str::contains($row['celular'], $request->get('celular')) ? true : false;
        //             });
        //         }
                
        //         if (!empty($request->get('search'))) {
        //             $instance->collection = $instance->collection->filter(function ($row) use ($request) {
        //                 if (Str::contains(Str::lower($row['tipodocumento']), Str::lower($request->get('search')))) {
        //                     return true;
        //                 } else if (Str::contains(Str::lower($row['documento']), Str::lower($request->get('search')))) {
        //                     return true;
        //                 } else if (Str::contains(Str::lower($row['nombre']), Str::lower($request->get('search')))) {
        //                     return true;
        //                 } else if (Str::contains(Str::lower($row['email']), Str::lower($request->get('search')))) {
        //                     return true;
        //                 } else if (Str::contains(Str::lower($row['celular']), Str::lower($request->get('search')))) {
        //                     return true;
        //                 } 
        //                 return false;
        //             });
        //         }
        //     })
            ->rawColumns(['detail', 'celular'])
            ->make(true);
    }

    /*=====  End of metodo para mostrar todos los usuarios en datatables  ======*/

    
}