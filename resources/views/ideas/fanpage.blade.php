@extends('spa.layouts.app')

@section('meta-tittle', 'Inicio')
@section('meta-content', 'Inicio')
@section('content-spa')
<main class="mn-inner no-p">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <h5>
                    <a class="footer-text left-align" href="">
                        <i class="material-icons arrow-l">
                            arrow_back
                        </i>
                    </a>
                    Ideas de Proyecto
                </h5>
                <div class="card stats-card">
                    <div class="card-content">
                        <div class="row">
                            <form class="col s12 m12 l12" id="formregisteridea" method="post">
                                <div class="card red lighten-3">
                                    <div class="row">
                                        <div class="col s12 m10">
                                            <div class="card-content white-text">
                                                <p>
                                                    <i class="material-icons left">
                                                        info_outline
                                                    </i>
                                                    Los datos marcados con * son obligatorios
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <center>
                                    <p align="center" class="description text-center">
                                        Ingresa tu idea de proyecto aquí debajo.
                                    </p>
                                </center>
                                <center>
                                    <span class="card-title center-align">
                                        Datos del Contacto
                                        <i class="Small material-icons prefix">
                                            contacts
                                        </i>
                                    </span>
                                </center>
                                <div class="divider">
                                </div>
                                <br>
                                    <div class="row">
                                        <div class="input-field col s12 m6 l6">
                                            <i class="material-icons prefix">
                                                account_circle
                                            </i>
                                            <input class="validate" id="txtnombres" name="txtnombres" type="text">
                                                <label for="txtnombres">
                                                    Nombres *
                                                </label>
                                            </input>
                                        </div>
                                        <div class="input-field col s12 m6 l6">
                                            <i class="material-icons prefix">
                                                account_circle
                                            </i>
                                            <input class="validate" id="txtapellidos" name="txtapellidos" type="text">
                                                <label for="txtapellidos">
                                                    Apellidos *
                                                </label>
                                            </input>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12 m6 l6">
                                            <i class="material-icons prefix">
                                                email
                                            </i>
                                            <input class="validate" id="txtcorreo" name="txtcorreo" type="email">
                                                <label for="txtcorreo">
                                                    Correo Electronico *
                                                </label>
                                            </input>
                                        </div>
                                        <div class="input-field col s12 m6 l6">
                                            <i class="material-icons prefix">
                                                phone
                                            </i>
                                            <input class="validate" id="txtcontacto" name="txtcontacto" type="tel">
                                                <label for="txtcontacto">
                                                    Contacto
                                                </label>
                                            </input>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12 m6 l6">
                                            <i class="material-icons prefix">
                                                library_books
                                            </i>
                                            <input class="validate" id="txtnombreproyecto" name="txtnombreproyecto" type="text">
                                                <label for="txtnombreproyecto">
                                                    Nombre de Proyecto *
                                                </label>
                                            </input>
                                        </div>
                                        <div class="input-field col s12 m6 l6">
                                            <i class="material-icons prefix">
                                                domain
                                            </i>
                                            <label class="active" for="txtnombreproyecto">
                                                Nodo *
                                            </label>
                                            <select class=" " id="txtnodo" name="txtnodo" style="width: 100%" tabindex="-1">
                                                <option value="">
                                                    Seleccione Nodo *
                                                </option>
                                                
                                            </select>
                                            <div class="row">
                                                <div class="input-field col s2 m6 l6 offset-l8 m8 s2">
                                                    <a class="waves-effect waves-light btn" href="" target="_blank">
                                                        <i class="material-icons left">
                                                            map
                                                        </i>
                                                        ver mapa
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </br>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
