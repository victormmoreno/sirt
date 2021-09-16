<?php

namespace App\Repositories\Repository;

use App\Models\Support;
use App\Events\Support\MessageWasSent;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SupportRepository
{
    private $strError = null;

    public function getError()
    {
        return $this->strError;
    }
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
            $support = Support::create([
                'ticket'        => $this->generateTiket(),
                'name'          => $user->nombres,
                'lastname'      => $user->apellidos,
                'document'      => $user->documento,
                'email'         =>  $request->input('txtemail'),
                'phone'         => $user->celular  ,
                'subject'       => $request->input('txtasunto'),
                'description'   => $request->input('txtmensaje'),
                'difficulty'    => $request->input('cmbsolicitud'),
                'status'        => Support::IsPendiente()
            ]);

            $message = [
                'ticket'          => $support->ticket,
                'name'          => $support->name,
                'lastname'      => $support->lastname,
                'document'      => $support->document,
                'email'         =>  $support->email,
                'phone'         => $support->phone  ,
                'subject'       => $support->subject,
                'description'   => $support->description,
                'difficulty'    => $support->difficulty,
                'status'        => $support->status,
                'archive'      => $request->file('filedocument')
            ];

            event(new MessageWasSent($message));
            DB::commit();
            return true;
        } catch (\Exception $e) {
            $this->strError = $e->getMessage();
            DB::rollback();
            return false;
        }
    }

    private function generateTiket(){
        $anio = Carbon::now();
        $support = Support::selectRaw('MAX(id+1) AS max')->get()->last();
        $support->max == null ? $support->max = 1 : $support->max = $support->max;
        $support->max = sprintf("%04d", $support->max);
        return 'T' . $anio->isoFormat('YYYY') .  $anio->isoFormat('MM') . $anio->isoFormat('DD') . substr(auth()->user()->document, 1, 4) . $support->max;
    }

}
