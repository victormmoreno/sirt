@extends('layouts.app')

@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s10 m10 l10">
                        <h5 class="left-align">
                            <i class="material-icons left">
                                supervised_user_circle
                            </i>
                            Usuarios
                        </h5>
                    </div>
                </div>
                <div class="card ">
                    <div class="card-content">
                        <div class="row">
                            <div class="row">
                                <div class="col s12 m12 l10">
                                    <div class="center-align">
                                        <span class="card-title center-align">
                                            Usuarios {{ config('app.name')}}
                                        </span>
                                    </div>
                                </div>
                                {!! $dataTable->table() !!}

                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection

@push('script')
<!-- DataTables Button -->
        <script src="//cdn.datatables.net/buttons/1.1.0/js/buttons.print.min.js"></script>
{!! $dataTable->scripts() !!}
@endpush