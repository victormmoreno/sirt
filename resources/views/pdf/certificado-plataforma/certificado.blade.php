@extends('pdf.illustrated-layout')
@section('title', 'Certificado |' . $user->nombres . ' '. $user->apellidos)
@section('image-header')
<p class="title-date">
    http://sennova.senaedu.edu.co
</p>
<div class="header">
    <div class="center">
        <p class="z-depth-3">
            <center>
                <img class="card-image" src="{{asset('img/logonacional_Negro.png')}}">
                </img>
            </center>
        </p>
    </div>
</div>
@endsection


@section('message')
<div class="certificad">
    <h1 class="tittle">
        Certificado de Registro en el Sistema
    </h1>
    <p class="promotion">
        La Red Tecnoparque Colombia
brinda un servicio que apoya el desarrollo de proyectos innovadores de base tecnológica para generar productos y servicios  que contribuyan al crecimiento económico y la competitividad del país y las regiones, apalancados en los sectores de clase mundial.
        <br/>
        <br/>
        Siendo un programa de innovación tecnológica del Servicio Nacional de Aprendizaje (SENA) dirigida a todos los Colombianos, que actúa como acelerador para el desarrollo de proyectos de I+D+i, La Red Tecnoparque Colombia,  hace constar que el señor(a)
        <b>
            {{$user->nombres}} {{$user->apellidos}}
        </b>
        identificado con
{{$user->tipodocumento->nombre}} {{$user->documento}}, se inscribió en nuestro sistema el día
{{$user->created_at->isoFormat('LL')}}.
        <br/>
        <br/>
        El presente certificado se genera el día {{Carbon\Carbon::now()->isoFormat('LL')}}, por solicitud del interesado.
        <br/>
        <br/>
        Recuerde que todos nuestros servicios son públicos, gratuitos, indiscriminados y
no requieren intermediarios.
    </p>
    <div class="footer">
        <img class="image-footer-left" src="{{asset('img/logonacional_Negro.png')}}"/>
        <img class="image-footer-right" src="{{asset('img/sennova.png')}}"/>
        <p class="center">
            {{config('app.url')}}
        </p>
    </div>
</div>
@endsection
