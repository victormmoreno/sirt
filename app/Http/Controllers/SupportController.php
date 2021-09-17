<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupportRequest;
use App\Models\Support;
use App\Repositories\Repository\SupportRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class SupportController extends Controller
{

    private $supportRepository;

    public function __construct(SupportRepository $supportRepository)
    {
        $this->middleware(['auth']);
        $this->supportRepository = $supportRepository;
    }

    public function send()
    {
        return view('supports.send', ['user' => auth()->user()]);
    }

    public function index(Request $request)
    {
        if (request()->ajax()) {
            return $this->supportRepository->filterSupports($request);;
        }
        return view('supports.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $req       = new SupportRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'fail'   => true,
                'errors' => $validator->errors(),
                'redirect_url' => null,
            ]);
        }
        $result = $this->supportRepository->storeContact($request);
        if (!$result) {
            return response()->json([
                'fail'         => true,
                'errors'       => $this->supportRepository->getError(),
                'redirect_url' => null,
            ]);
        }
        return response()->json([
            'fail'         => false,
            'errors'       => null,
            'redirect_url' => url(route('support.send')),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Support  $support
     * @return \Illuminate\Http\Response
     */
    public function show(Support $support)
    {
        return view('supports.show', ['support' => $support]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Support  $support
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Support $support)
    {
        $support->update([
            'status'        => $request->status,
        ]);
        return response()->json([
            'fail'         => false,
            'redirect_url' => route('support.show', $support->ticket),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Support  $support
     * @return \Illuminate\Http\Response
     */
    public function destroy(Support $support)
    {
        $support->delete();
        return response()->json([
            'fail'         => false,
            'redirect_url' => route('support.index'),
        ]);
    }
}
