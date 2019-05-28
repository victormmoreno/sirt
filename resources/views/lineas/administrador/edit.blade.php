@extends('layouts.app')

@section('content')

<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <h5>
                    <a class="footer-text left-align" href="">
                        <i class="material-icons arrow-l">
                            arrow_back
                        </i>
                    </a>
                    Lineas
                </h5>
                <div class="card stats-card">
                    <div class="card-content">
                        <div class="row">
                            <div class="row">
                                <center><span class="card-title center-align">Editar Linea <b>{{$linea->nombre}}</b></span> <i class="Small material-icons prefix">dns </i></center>
                                <form action="{{ route('lineas.update', $linea->id)}}" method="POST">
                                	{!! method_field('PUT')!!}
	                                @include('lineas.administrador.form', [
								    	'btnText' => 'Actualizar',
								   	])
							   	</form>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection