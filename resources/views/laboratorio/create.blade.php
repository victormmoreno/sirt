@extends('layouts.app')

@section('meta-title', 'Nuevo Laboratorio')

@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s8 m8 l9">
                        <h5 class="left-align">
                            <a class="footer-text left-align" href="{{route('laboratorio.index')}}">
                                <i class="material-icons arrow-l">
                                    arrow_back
                                </i>
                            </a>
                            Laboratorio
                        </h5>
                    </div>
                    <div class="right col s4 m4 l3 ">
                        <ol class="breadcrumbs">
                            <li>
                                <a href="{{route('home')}}">
                                    Inicio
                                </a>
                            </li>
                            <li>
                                <a href="{{route('laboratorio.index')}}">
                                    Laboratorios
                                </a>
                            </li>
                            <li class="active">
                                Nuevo Laboratorio
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m12 l12">
                        <div class="card">
                            <div class="card-content">
                                <div class="row no-m-t no-m-b">
                                    <div class="col s12 m12 l12">
                                        <div class="mailbox-view">
                                            <div class="mailbox-view-header">
                                                <div class="center mailbox-buttons">
                                                    <span class="mailbox-title">
                                                        <p class="center">
                                                            @if(session()->has('login_role') && session()->get('login_role') == App\User::IsAdministrador())
                                                            Nuevo Laboratorio {{config('app.name')}}
                                                            @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsDinamizador())
                                                                Nuevo Laboratorio Tecnoparque Nodo {{\NodoHelper::returnNameNodoUsuario()}}
                                                            @endif
                                                        </p>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="divider mailbox-divider">
                                            </div>
                                            <div class="mailbox-text">
                                                <form action="{{ route('laboratorio.store')}}" method="POST" onsubmit="return checkSubmit()">
                                                    @include('laboratorio.form', [
                                                        'btnText' => 'Guardar',
                                                    ])
                                                </form>
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
@push('script')
<script>
@if(session()->has('login_role') && session()->get('login_role') == App\User::IsAdministrador())
        $(document).ready(function() {
            @if($errors->any())
                lineaLaboratorio.getSelectLineaForNodo();
            @endif
        });
    var lineaLaboratorio = {
        getSelectLineaForNodo:function(){
          let nodo = $('#txtnodo').val();
          $.ajax({
            dataType:'json',
            type:'get',
            url:'/lineas/getlineasnodo/'+nodo
          }).done(function(response){
            $('#txtlinea').empty();
            if (response.lineasForNodo.lineas == '') {
                $('#txtlinea').append('<option value="">No hay lineas disponibles</option>');
            }else{
                
                $('#txtlinea').append('<option value="">Seleccione la linea</option>');

                $.each(response.lineasForNodo.lineas, function(i, e) {
                    $('#txtlinea').append('<option  value="'+e.id+'">'+e.nombre+'</option>');
                });
                @if($errors->any())
                  $('#txtlinea').val("{{old('txtlinea')}}");
                @endif
            }
            
            $('#txtlinea').material_select();
          });
        },

      }
@endif
</script>
@endpush
