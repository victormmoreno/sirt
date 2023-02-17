<?php

namespace App\Http\Controllers\Articulation;

use App\Models\ArticulationStage;
use App\Repositories\Repository\Articulation\ArticulationStageRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use RealRashid\SweetAlert\Facades\Alert;

class ArticulationStageApprovalsController extends Controller
{
    private $articulationStageRepository;
    public function __construct(ArticulationStageRepository $articulationStageRepository)
    {
        $this->articulationStageRepository = $articulationStageRepository;
        $this->middleware(['auth']);
    }
    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function requestApproval(int $id, string $phase = null)
    {
        $articulationStage = ArticulationStage::findOrFail($id);
        if (request()->user()->cannot('requestApproval', $articulationStage))
        {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $notification = $this->articulationStageRepository->notifyApprovalEndorsement($articulationStage, $phase);
        if ($notification['notificacion']) {
            Alert::success('Notificación Exitosa!', $notification['msg'])->showConfirmButton('Ok', '#3085d6');
        } else {
            Alert::error('Notificación Errónea!', $notification['msg'])->showConfirmButton('Ok', '#3085d6');
        }
        return back();
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function manageEndorsement(Request $request, $id, string $phase = null)
    {
        $articulationStage = ArticulationStage::findOrFail($id);
        if (request()->user()->cannot('showButtonAprobacion', $articulationStage))
        {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $update = $this->articulationStageRepository->manageEndorsement($request, $articulationStage, $phase);
        if ($update['state']) {
            Alert::success($update['title'], $update['mensaje'])->showConfirmButton('Ok', '#3085d6');
            return back();
        } else {
            Alert::error($update['title'], $update['mensaje'])->showConfirmButton('Ok', '#3085d6');
            return back();
        }
    }


}
