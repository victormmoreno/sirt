<?php

namespace App\Repositories\Repository;

use App\Models\Contact;
use Illuminate\Support\Facades\DB;

class ContactRepository
{
    /**
     * retorna registro de un uso de infraestructura
     * @return bool
     * @param $request
     * @author devjul
     */
    public function storeContact($request)
    {

        DB::beginTransaction();
        try {
            $user = auth()->user();
            Contact::create([
                'name'          => $user->nombres,
                'lastname'      => $user->apellidos,
                'document'      => $user->documento,
                'email'         =>  $request->input('txtemail'),
                'phone'         => $user->celular  ,
                'subject'       => $request->input('txtasunto'),
                'description'   => $request->input('txtmensaje'),
                'difficulty'    => $request->input('cmbsolicitud'),
                'status'        => Contact::IsPendiente()
            ]);
            event(new ProyectoWasntApproved($proyecto, $movimiento));
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

}
