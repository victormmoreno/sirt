@php
    $asesor = auth()->user();
@endphp
@extends('pdf.illustrated-layout')
@section('title-file', 'Acta de seguimiento')
@section('styles')
<style>
    @page {
            margin: 20px 10px;
            border: solid;

        }
</style>
@endsection
@section('content-pdf')
<main class="card-content">
        <table class="bordered">
            <tr>
                <td colspan="2" rowspan="2"><img class="center-image" src="{{asset('img/web.png')}}"></td>
                <td colspan="6" class="centered"><b>Seguimiento de Asesorias y Uso Infraestructura<b></td>
            </tr>
            <tr>
                <td colspan="6" class="centered">
                @if ($tipo_actividad == 'proyecto')
                    <b>ACTA No. {{ $data->id . "-" . Carbon\Carbon::now()->isoFormat('YYYY-MM-DD') }}<b>
                @elseif($tipo_actividad == 'articulacion')
                    <b>ACTA No. {{ substr($data->code, -4) . "-" . Carbon\Carbon::now()->isoFormat('YYYY-MM-DD') }}<b>
                @else
                <b><b>
                @endif
                </td>
            </tr>
            <tr class="tr-striped">
                <td colspan="8" ><b>Información general<b></td>
            </tr>
            <tr>
            @if ($tipo_actividad == 'proyecto')
                <td colspan="2">Código del proyecto</td>
                <td colspan="2">Nombre del proyecto</td>
                <td colspan="2">Asesor a cargo del proyecto</td>
                <td colspan="2">Sublínea tecnológica</td>
            @elseif($tipo_actividad == 'articulacion')
                <td colspan="2">Código de la articulación</td>
                <td colspan="3">Nombre de la articulación</td>
                <td colspan="3">Asesor a cargo de la articulación</td>
            @else
                <td colspan="8">No Registra</td>
            @endif
            </tr>
            <tr>
                @if ($tipo_actividad == 'proyecto')
                    <td colspan="2">{{ $data->codigo_proyecto }}</td>
                    <td colspan="2">{{ $data->nombre }}</td>
                    <td colspan="2">{{ $data->gestor }}</td>
                    <td colspan="2">{{ $data->abreviatura_linea }} - {{ $data->sublinea_nombre }}</td>
                @elseif($tipo_actividad == 'articulacion')
                    <td colspan="2">{{$data->code}}</td>
                    <td colspan="3">{{$data->name }}</td>
                    <td colspan="3"></td>
                @else
                    <td colspan="8">No Registra</td>
                @endif
            </tr>
            <tr class="tr-striped">
                <td colspan="8" >
                    <b>
                    @if ($tipo_actividad == 'proyecto')
                        Talentos del Proyecto
                    @elseif($tipo_actividad == 'articulacion')
                        Talentos de la Articulación
                    @else
                        Talentos
                    @endif
                    </b>
                </td>
            </tr>
            @if ($tipo_actividad == 'proyecto')
                <tr>
                    <td colspan="2">Número de documento</td>
                    <td colspan="2">Nombres y apellidos</td>
                    <td colspan="2">Correo electrónico</td>
                    <td colspan="2">Número de contacto</td>
                </tr>
                @forelse ($data->talentos as $value)
                    <tr>
                        <td colspan="2">{{ $value->documento }}</td>
                        <td colspan="2">{{ $value->nombres . ' ' . $value->nombres }}</td>
                        <td colspan="2">{{ $value->email }}</td>
                        <td colspan="2">{{ $value->celular }} - {{ $value->telefono }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">No hay información disponible</td>
                        <td colspan="2">No hay información disponible</td>
                        <td colspan="2">No hay información disponible</td>
                        <td colspan="2">No hay información disponible</td>
                    </tr>
                @endforelse
            @elseif($tipo_actividad == 'articulacion')
                <tr>
                    <td colspan="2">Número de documento</td>
                    <td colspan="2">Nombres y apellidos</td>
                    <td colspan="2">Correo electrónico</td>
                    <td colspan="2">Número de contacto</td>
                </tr>
                @forelse ($data->users as $user)
                    <tr>
                        <td colspan="2">{{ $user->present()->userDocumento() }}</td>
                        <td colspan="2">{{ $user->present()->userFullName()}}</td>
                        <td colspan="2">{{ $user->present()->userEmail() }}</td>
                        <td colspan="2">{{ $user->present()->userCelular() }} - {{ $user->present()->userTelefono() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">No hay información disponible</td>
                        <td colspan="2">No hay información disponible</td>
                        <td colspan="2">No hay información disponible</td>
                        <td colspan="2">No hay información disponible</td>
                    </tr>
                @endforelse
            @else
                <tr>
                    <td colspan="8">No Registra</td>
                </tr>
            @endif
            <tr class="tr-striped">
                <td colspan="8" >
                    <b>Asesorías y usos</b>
                </td>
            </tr>
            <tr>
                <td colspan="1" rowspan="2">Fecha de la Asesoría y uso</td>
                <td colspan="1" rowspan="2">Horas de Asesoria Directa</td>
                <td colspan="1" rowspan="2">Horas de Asesoria Indirecta</td>
                <td colspan="1" rowspan="2">Equipos</td>
                <td colspan="1" rowspan="2">Materiales de Formación</td>
                <td colspan="2" rowspan="2">Descripción</td>
                <td colspan="1" rowspan="2">Funcionario / Talento</td>
            </tr>
            <tr>
            </tr>
                @forelse ($data->asesorias->sortBy('fecha')->values()->all() as $value)
                <tr>
                    <td>{{ $value->fecha->isoFormat('YYYY-MM-DD') }}</td>
                    <td>{{ $value->usogestores->sum('pivot.asesoria_directa') }}</td>
                    <td>{{ $value->usogestores->sum('pivot.asesoria_indirecta') }}</td>
                    <td>{{ $value->usoequipos->map(function ($item, $key) {
                                if(isset($item)){
                                    return $item->referencia . ' - ' . $item->present()->equipoNombre() . ' - Horas Uso: ' . $item->pivot->tiempo;
                                }
                                return "No registra";
                            })->implode(', ')}}
                    </td>
                    <td>
                        {{ $value->usomateriales->map(function ($item, $key) {
                            if(isset($item)){
                                return $item->codigo_material . ' - ' . $item->nombre. ' - Cantidad Uso: ' . $item->pivot->unidad;
                            }
                            return "No registra";
                        })->implode(', ')}}
                    </td>
                    <td colspan="2" >{{$value->descripcion}}</td>
                    <td colspan="1" >{{$value->present()->asesor()}}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">No Registra</td>
                </tr>
                @endforelse
            @if ($tipo_actividad == 'proyecto')
                <tr class="tr-striped">
                    <td colspan="8" ><b>Certificación<b></td>
                </tr>

                <tr>
                    <td colspan="4" >{{$asesor->documento}} -  {{$asesor->nombres}} {{$asesor->apellidos}} - Asesor</td>
                    <td colspan="4"  class="h-70p"></td>
                </tr>

                <tr>
                    <td colspan="4" >{{$data->present()->talentoInterlocutor()}} - Talento Interlocutor</td>
                    <td colspan="4"  class="h-70p"></td>
                </tr>
            @elseif($tipo_actividad == 'articulacion')
                <tr class="tr-striped">
                    <td colspan="8" ><b>Certificación<b></td>
                </tr>
                <tr>
                    <td colspan="4" >{{$asesor->documento}} -  {{$asesor->nombres}} {{$asesor->apellidos}} - Asesor</td>
                    <td colspan="4"  class="h-70p"></td>
                </tr>
                <tr>
                    <td colspan="4" >{{$data->articulationStage->present()->articulationStageInterlocutorTalent()}} - Talento Interlocutor</td>
                    <td colspan="4"  class="h-70p"></td>
                </tr>
            @else
            <tr>
                <td colspan="8">No Registra</td>
            </tr>
            @endif
        </table>
</main>
@endsection
