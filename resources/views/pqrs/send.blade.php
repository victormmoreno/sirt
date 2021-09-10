@extends('layouts.app')
@section('meta-title', 'PQRS')
@section('content')
<main class="mn-inner inner-active-sidebar">

    <div class="orange darken-1 z-depth-2">
        <div class="container ">
            <div class="row">
                <div class="col s12 m12 l12">
                    <div class="card card-transparent no-m ">
                        <div class="card-content  white-text">
                            <div class="row">
                                <div class="col s12 m6 l6">
                                    <h4>Contactenos</h4>
                                    <address>
                                        Medellín, Antioquia<br>
                                        calle 56 # 11 - piso 7
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
    <div class="row">

        <div class="col s12 m10 l6 offset-l3 offset-m1 z-depth-3">
            <div class="card card-transparent mt-2 ">
                <div class="card-content ">
                    <span class="card-title">PQRS</span>
                    <address>
                        <strong>{{config('app.name')}}</strong><br>
                        {{-- 795 Folsom Ave, Suite 600<br>
                        San Francisco, CA 94107<br> --}}
                        {{-- <abbr title="Phone">P:</abbr> (123) 456-7890 --}}
                    </address>
                </div>
                <div class="card-content ">
                    <span class="card-title">MANTENGÁMONOS EN CONTACTO</span>
                    <form class="m-t-md">
                        <div class="row">
                            <div class="input-field col s12">
                                <select>
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <option value="1">Petición</option>
                                    <option value="2">Queja</option>
                                    <option value="3">Reclamo</option>
                                </select>
                                <label>Tipo Solicitud</label>
                            </div>
                            <div class="input-field col s12">
                                <input id="first_name" type="text" class="validate">
                                <label for="first_name">Asunto</label>
                            </div>
                            <div class="input-field col s12">
                                <input id="email" type="email" value="{{$user->email}}" class="validate">
                                <label for="email">Correo Electónico</label>
                            </div>
                            <div class="input-field col s12">
                                <textarea id="message" class="materialize-textarea"></textarea>
                                <label for="message">Mensaje</label>
                            </div>
                        </div>
                        <div>
                            <div class="file-field input-field">
                                <div class="btn yellow darken-2">
                                    <span>Archivo</span>
                                    <input type="file">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" placeholder="Sube un documento PDF (Opcional)">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <a href="#!" class="waves-effect waves-light btn orange m-b-xs right">Enviar</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

