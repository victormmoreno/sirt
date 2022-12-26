@extends('layouts.app')
@section('meta-title', 'Soporte')

@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="row no-m-t no-m-b">
        <div class="bg-primary z-depth-2">
            <div class="container ">
                <div class="row">
                    <div class="col s12 m12 l12">
                        <div class="card card-transparent no-m ">
                            <div class="card-content  white-text">
                                <div class="row">
                                    <div class="col s12 m6 l6">
                                        <h4>{{config('app.technical_support.title')}}</h4>
                                        <address>
                                            [{{$support->present()->ticket()}}]<br>
                                            {{$support->present()->subject()}}
                                            {{config('app.technical_support.contact.phone')}}
                                        </address>
                                    </div>
                                    <div class="col s12 m6 l6 right-align hide-on-small-only">
                                        <i class="large material-icons">sms</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row no-m-t no-m-b">
                <div class="col s12 m12 l12 no-p-h">
                    <div class="card mailbox-content">
                        <div class="card-content">
                            <div class="row no-m-t no-m-b">

                                <div class="col s12 m12 l12">
                                    <div class="mailbox-options">
                                        <ul>
                                            @if($support->status != App\Models\Support::IsEspera())
                                            <li><a href="javascript:void(0)" onclick="support.updateSupport('{{$support->ticket}}', '{{App\Models\Support::IsEspera()}}')">Marcar como En Espera</a></li>
                                            @endif
                                            @if($support->status != App\Models\Support::IsPendiente())
                                            <li><a href="javascript:void(0)" onclick="support.updateSupport('{{$support->ticket}}', '{{App\Models\Support::IsPendiente()}}')">Marcar como Pendiente</a></li>
                                            @endif
                                            @if($support->status != App\Models\Support::IsSolucionado())
                                                <li><a href="javascript:void(0)" onclick="support.updateSupport('{{$support->ticket}}', '{{App\Models\Support::IsSolucionado()}}')">Marcar como solucionado</a></li>
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="mailbox-view">
                                        <div class="mailbox-view-header">
                                            <div class="left">
                                                <div class="left">
                                                    <span class="mailbox-title">[{{$support->present()->ticket()}}] {{$support->present()->subject()}}</span>
                                                    <span class="mailbox-author">{{$support->present()->fullname()}}</span>

                                                </div>
                                            </div>
                                            <div class="right mailbox-buttons">
                                                <a href="javascript:void(0)" class="waves-effect waves-red btn-flat m-t-xs" onclick="support.destroySupport('{{$support->ticket}}')">Eliminar</a>
                                            </div>
                                        </div>
                                        <div class="divider mailbox-divider"></div>
                                        <div class="mailbox-text">
                                            @if($support->status == App\Models\Support::IsEspera())
                                                <div class="chip bg-warning white-text">{{$support->status}}</div>
                                            @elseif($support->status == App\Models\Support::IsPendiente())
                                                <div class="chip bg-danger white-text ">{{$support->status}}</div>
                                            @else
                                                <div class="chip bg-success white-text">{{$support->status}}</div>
                                            @endif
                                            <div class="chip">{{$support->present()->difficulty()}}</div>
                                            <div class="mailbox-details">

                                                <div class="row details-list" style="display: block;">
                                                    <div class="col s4 l4 first-col">
                                                        <span>De</span>
                                                        <span>Documento</span>
                                                        <span>Enviado</span>
                                                        <span>Teléfono</span>
                                                        <span>Fecha</span>
                                                    </div>
                                                    <div class="col s8 l8 second-col">
                                                        <span>{{$support->present()->email()}}</span><br>
                                                        <span>{{$support->present()->document()}}</span><br>
                                                        <span>{{$support->present()->fullname()}}</span><br>
                                                        <span>{{$support->present()->phone()}}</span><br>
                                                        <span>{{$support->created_at->isoFormat('lll')}} ({{$support->created_at->diffForHumans()}})</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <p>{{$support->present()->description()}}</p>
                                            <div class="divider mailbox-divider"></div>
                                            <div class=" rigth ">
                                                <div class="row details-list" style="display: block;">
                                                    <div class="col s4 l4 first-col">
                                                        <span>Fecha actualización</span>
                                                    </div>
                                                    <div class="col s8 l8 second-col">
                                                        <span>{{$support->updated_at->isoFormat('lll')}} ({{$support->updated_at->diffForHumans()}})</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</main>
@endsection
