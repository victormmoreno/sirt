<?php

namespace App\Repositories\Repository;

use App\Models\Support;
use App\Events\Support\MessageWasSent;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

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

    public function filterSupports($request)
    {
        $supports = Support::createdAt($request->filter_year_support)
                ->status($request->filter_state_support)
                ->difficulty($request->filter_request_support)
                ->orderBy('created_at', 'desc')
                ->get();

        return $this->datatableSupport($supports);
    }

    private function datatableSupport($supports)
    {
        return datatables()->of($supports)
        ->editColumn('created_at', function ($data) {
            return $data->created_at
            ->settings(['formatFunction' => 'translatedFormat'])
            ->isoFormat('lll');
        })
        ->editColumn('name', function ($data) {
            return "{$data->present()->document()} - {$data->present()->fullname()}";
        })
        ->editColumn('subject', function ($data) {
            return Str::limit($data->subject, 20);
        })
        ->editColumn('email', function ($data) {
            return Str::limit($data->email, 20);
        })

        ->editColumn('status', function ($data) {
            if($data->status == Support::IsPendiente()){
                return  '<div class="chip red white-text text-darken-2">'.$data->status.'</div>';
            }
            if($data->status == Support::IsEspera()){
                return  '<div class="chip orange white-text text-darken-2">'.$data->status.'</div>';
            }
            if($data->status == Support::IsSolucionado()){
                return  '<div class="chip green white-text text-darken-2">'.$data->status.'</div>';
            }

        })
        ->addColumn('show', function ($data) {
            return '<a class="btn m-b-xs modal-trigger" href='.route('support.show', $data->ticket).'>
            <i class="material-icons">search</i>
            </a>';
        })
        ->rawColumns(['created_at', 'status',  'show'])->make(true);
    }

}
