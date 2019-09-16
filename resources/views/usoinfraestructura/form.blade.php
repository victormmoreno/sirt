<div class="row">
    <div class="col s12 m3 l3">
        <blockquote>
            <ul class="collection">
                <li class="collection-item">
                    <span class="title"><b>Nodo</b></span>
                    <p>señor(a) ususario, por favor ingrese la información que se solcita en formulario.</p>
                </li>
                <li class="collection-item">
                    <span class="title"><b>Nodo</b></span>
                    <p>Por favor sólo ingrese el nombre del nodo. Ejemplo (Medellin)</p>
                </li>
            </ul>
        </blockquote>
    </div>
    <div class="col s12 m9 l9">

        <fieldset>
            <legend>Paso 1</legend>
            {!! csrf_field() !!}
            <p class="center card-title cyan-text text-darken-4">
               <b> <i class="medium material-icons center">info_outline</i> Seleccione a que se le hará el uso de infraestructura</b> 
            </p>
            <div class="row">
                <div class="input-field col s12 m12 l12">
                    <p class="center p-v-xs">
                        <input class="with-gap" id="IsProyecto" name="txttipousoinfraestructura" type="radio" value="0"/>
                        <label for="IsProyecto">
                            Proyectos
                        </label>
                        <input class="with-gap" id="IsArticulacion" name="txttipousoinfraestructura" type="radio" value="1"/>
                        <label for="IsArticulacion">
                            Articulaciones
                        </label>
                        @if(session()->has('login_role') && session()->get('login_role') == App\User::IsGestor())
                            <input class="with-gap" id="IsEdt" name="txttipousoinfraestructura" type="radio" value="2"/>
                            <label for="IsEdt">
                                EDT
                            </label>
                        @endif
                    </p>
                    <center>
                        <small class="center-align error red-text" id="txttipousoinfraestructura-error">
                        </small>
                    </center>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 m4 l4">
                    <i class="material-icons prefix">
                        date_range
                    </i>
                    <input class="datepicker" id="txtfecha" name="txtfecha" type="text" value="{{$date}}">
                        <label for="txtfecha">
                            fecha
                            <span class="red-text">
                                *
                            </span>
                        </label>
                        <label class="error" for="txtfecha" id="txtfecha-error"></label>
        
                    </input>
                </div>
                <div class="input-field col s12 m4 l4">
                    <i class="material-icons prefix">
                        vertical_split
                    </i>
                    @if(session()->has('login_role') && session()->get('login_role') == App\User::IsGestor())
                    <input id="txtlinea" name="txtlinea" readonly="" type="text" value="{{$authUser->gestor->lineatecnologica->nombre}}"/>
                    @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsTalento())
                        <input id="txtlinea" name="txtlinea" readonly="" type="text" value="primero seleccione el tipo de uso de infraestructura"/>
                    @endif
                    <label class="active" for="txtlinea">
                        Linea
                        <span class="red-text">
                            *
                        </span>
                    </label>
                    <label class="error" for="txtlinea" id="txtlinea-error">
                    </label>
                </div>
                <div class="input-field col s12 m4 l4">
                    <i class="material-icons prefix">
                        account_circle
                    </i>
                    @if(session()->has('login_role') && session()->get('login_role') == App\User::IsGestor())
                    <input id="txtgestor" name="txtgestor" readonly="" type="text" value="{{$authUser->documento}} - {{$authUser->nombres}} {{$authUser->apellidos}}"/>
                    @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsTalento())
                        <input id="txtgestor" name="txtgestor" readonly="" type="text" value="primero seleccione el tipo de uso de infraestructura"/>
                    @endif
                    <label class="active" for="txtgestor">
                        Gestor
                        <span class="red-text">
                            *
                        </span>
                    </label>
                    <label class="error" for="txtgestor" id="txtgestor-error">
                    </label>
                  
                </div>
        </div>
        
        <div class="divActividad">
            <div class="row">
                 <div class="input-field col s12 m12 l12">
                    <i class="material-icons prefix">
                        library_books
                    </i>
                    <input id="txtactividad" name="txtactividad"  type="text" readonly />
                    <label for="txtactividad">
                        Proyecto
                        <span class="red-text">
                            *
                        </span>
                    </label>
                </div>
            </div>
        </div>
        </fieldset>
    </div>
</div>
<div class="divider">
</div>
<div class="row">
    <div class="col s12 m3 l3">
        <blockquote>
            <ul class="collection">
                <li class="collection-item">
                    <span class="title"><b>Paso 2</b></span>
                    <p>
                        Si no se van a registrar horas de asesorias dejar el campo vacío
                    </p>
                </li>
                
            </ul>
        </blockquote>
    </div>
    <div class="col s12 m9 l9">
        <fieldset>
            <legend>Paso 2</legend>
            <div class="row">
                <div class="input-field col s12 m6 l6">
                    <i class="material-icons prefix">
                        book
                    </i>
                    <input id="txtasesoriadirecta" name="txtasesoriadirecta" type="text"  />
                    <label class="active" for="txtasesoriadirecta">
                        Asesoria Directa (Horas)
                    </label>
                    <label class="error" for="txtasesoriadirecta" id="txtasesoriadirecta-error"></label>
                 
                </div>
                <div class="input-field col s12 m6 l6">
                    <i class="material-icons prefix">
                        bookmark
                    </i>
                    <input id="txtasesoriaindirecta" name="txtasesoriaindirecta" type="text"  />
                    <label class="active" for="txtasesoriaindirecta">
                        Asesoria Indirecta (Horas)
                    </label>
                    <label class="error" for="txtasesoriaindirecta" id="txtasesoriaindirecta-error"></label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 m12 l8 offset-l2">
                    <i class="material-icons prefix">
                        create
                    </i>
                    <textarea class="materialize-textarea" id="txtdescripcion" length="2000" name="txtdescripcion">
                    </textarea>
                    <label for="txtdescripcion">
                        Descripción
                        <span class="red-text">
                            *
                        </span>
                    </label>
                    <label class="error" for="txtdescripcion" id="txtdescripcion-error"></label>
                </div>
            </div>
        </fieldset>
    </div>
</div>

<div class="divider">
</div>

<div class="card-content">
    <span class="red-text text-darken-2">
        Para registrar el uso de un laboratorio o la asistencia de un talento dar click en el boton
        <a class="btn-floating waves-effect waves-light blue">
            <i class="material-icons">
                add
            </i>
        </a>
    </span>
    <ul class="collapsible collapsible-accordion" data-collapsible="accordion">
        <li>
            <div class="collapsible-header active blue-grey lighten-1">
                <i class="material-icons">
                    domain
                </i>
                Seleccione detalle uso infraestructura
            </div>
            <p>
                <i class="material-icons left">
                    info_outline
                </i>
                Si no se van a registrar laboratorios y tiempo de uso, por favor no agregue al detalle de uso de infraestructura.
            </p>
            <div class="collapsible-body">
                <div class="card-content">
                    <div class="row">
                        <div class="input-field col s10 m10 l11">
                            <select class="js-states"    id="txttalento" name="txttalento" style="width: 100%" tabindex="-1">
                                <option value="">
                                    Seleccione primero el tipo de uso de infraestructura
                                </option>
                            </select>
                            <label class="active" for="txttalento">
                                Talento
                                <span class="red-text">
                                    *
                                </span>
                            </label>
                        </div>
                        <div class="input-field col s2 m2 l1">
                            <a class="btn-floating btn-large waves-effect waves-light blue lighten-1 tooltipped btnAgregarTalento" data-delay="50" data-position="button" data-tooltip="Agregar Talento" onclick="usoInfraestructuraCreate.addTalentoAUso()">
                                <i class="material-icons">
                                    add
                                </i>
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s5 m6 l6">
                            <!-- <i class="material-icons prefix">local_drink</i> -->
                            <select class="js-states" id="txtlaboratorio" name="txtlaboratorio" style="width: 100%" tabindex="-1">
                                <option value="">
                                    Seleccione Laboratorio
                                </option>
                            </select>
                            <label class="active" for="txtlaboratorio">
                                Laboratorio
                            </label>
                        </div>
                        <div class="input-field col s5 m4 l5">
                            <i class="material-icons prefix">
                                av_timer
                            </i>
                            <input class="validate" id="txttiempouso" name="txttiempouso" type="number">
                                <label for="txttiempouso">
                                    Tiempo Uso (Horas)
                                </label>
                            </input>
                        </div>
                        <div class="col s2 m2 l1">
                            <a class="btn-floating btn-large waves-effect waves-light blue lighten-1 tooltipped btnAgregartimelaboratorio" data-delay="50" data-position="button" data-tooltip="Agregar Uso"  onclick="usoInfraestructuraCreate.agregarLaboratorio()">
                                <i class="material-icons">
                                    add
                                </i>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6 l6">
                            <div class="card ">
                                <center>
                                    <p class="center-aling">
                                        Detalle Talentos
                                    </p>
                                </center>
                                <table class="striped centered responsive-table" id="tbldetallelineas">
                                    <thead>
                                        <tr>
                                            <th>
                                                Talentos
                                            </th>
                                            <th>
                                                Eliminar
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="detalleTalento">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="input-field col s12 m6 l6">
                            <div class="card ">
                                <center>
                                    <p class="center-aling">
                                        Detalle Uso
                                    </p>
                                </center>
                                <table class="striped centered responsive-table" id="tbldetallelineas">
                                    <thead>
                                        <tr>
                                            <th>
                                                Laboratorio
                                            </th>
                                            <th>
                                                Tiempo Uso
                                            </th>
                                            <th>
                                                Eliminar
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="detallesUsoInfraestructura">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</div>
<center>
   
    <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done_all</i>{{isset($btnText) ? $btnText : 'Guardar'}}</button> 
    <a class="btn waves-effect red lighten-2 center-aling" href="{{route('sublineas.index')}}">
        <i class="material-icons right">
            backspace
        </i>
        Cancelar
    </a>
</center>