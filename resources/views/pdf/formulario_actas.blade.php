@extends('layouts.app')
@section('meta-title', 'Generar documento')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
            <h5>
            <a class="footer-text left-align" href="{{url()->previous()}}">
                <i class="material-icons arrow-l left">arrow_back</i>
            </a> Generar documento
            </h5>
            <div class="card">
            <div class="card-content">
                <div class="row">
                <h4 class="center">Generar acta de {{$tipo}}</h4>
                </div>
                <div class="row">
                    <form id="frmGenerarDocumento" action="{{route('pdf.generar.doc', $data->id)}}" method="POST">
                        <div class="col s12 m12 l12 m-b-lg">
                            <div class="card-content bg-info white-text">
                                <p>
                                    <i class="material-icons left">info_outline</i>
                                    Para generar este documento es necesario ingresar la fecha y la hora a la que se realizó la reunión
                                </p>
                            </div>
                        </div>
                        @include('pdf.forms.form_compromiso', [
                        'btnText' => 'Modificar'])
                    </form>
                </div>
            </div>
            </div>
        </div>

        </div>
    </div>
</main>
@endsection
