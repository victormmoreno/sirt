{!! csrf_field() !!}
<p class="center card-title">
    Seleccione con quién será el uso de infraestructura
</p>
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
        <input class="with-gap" id="IsEdt" name="txttipousoinfraestructura" type="radio" value="2"/>
        <label for="IsEdt">
            EDT
        </label>
    </p>
    <center>
        <small class="center-align error red-text" id="txttipousoinfraestructura-error">
        </small>
    </center>
</div>
<div class="row">
    <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">
            vertical_split
        </i>
        <input id="txtlinea" name="txtlinea" readonly="" type="text" value="{{$authUser->gestor->lineatecnologica->nombre}}"/>
        <label class="active" for="txtlinea">
            Linea
            <span class="red-text">
                *
            </span>
        </label>
        @error('txtlinea')
        <label class="error" for="txtlinea" id="txtlinea-error">
            {{ $message }}
        </label>
        @enderror
    </div>
    <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">
            account_circle
        </i>
        <input id="txtgestor" name="txtgestor" readonly="" type="text" value="{{$authUser->documento}} - {{$authUser->nombres}} {{$authUser->apellidos}}"/>
        <label class="active" for="txtgestor">
            Gestor
            <span class="red-text">
                *
            </span>
        </label>
        @error('txtgestor')
        <label class="error" for="txtgestor" id="txtgestor-error">
            {{ $message }}
        </label>
        @enderror
    </div>
</div>
<div class="row">
    <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">
            date_range
        </i>
        <input class="datepicker" id="txtfecha" name="txtfecha" type="text">
            <label for="txtfecha">
                fecha
                <span class="red-text">
                    *
                </span>
            </label>
            @error('txtfecha')
            <label class="error" for="txtfecha" id="txtfecha-error">
                {{ $message }}
            </label>
            @enderror
        </input>
    </div>
    <div class="input-field col s12 m6 l6" id="divProyecto">
        {{-- <i class="material-icons prefix">
            library_books
        </i> --}}
        <select class="browser-default select2" id="txtproyecto" name="txtproyecto" style="width: 100%" tabindex="-1">
            <option value="">
                Seleccione Proyecto
            </option>
        </select>
        <label for="txtproyecto" class="active">
            Proyecto
            <span class="red-text">
                *
            </span>
        </label>
        @error('txtproyecto')
        <label class="error" for="txtproyecto" id="txtproyecto-error">
            {{ $message }}
        </label>
        @enderror
    </div>
    <div class="input-field col s12 m6 l6 divArticulacion">
        <i class="material-icons prefix">
            library_books
        </i>
        <select id="txttipoarticulacion" name="txttipoarticulacion" tabindex="-1" style="width: 100%;" class="initialized" onchange="usoInfraestructuraCreate.selectTipoArticulacion(this)">
            <option value="">Seleccione tipo articulación</option> 
            <option value="0">Grupo de Investigación</option> 
            <option value="1">Empresa</option> 
            <option value="2">Emprendedor</option> 
            
        </select>
        <label for="txttipoarticulacion">
            Tipo Articulación
            <span class="red-text">
                *
            </span>
        </label>
        @error('txttipoarticulacion')
        <label class="error" for="txttipoarticulacion" id="txttipoarticulacion-error">
            {{ $message }}
        </label>
        @enderror
    </div>
</div>
<div class="divArticulacion">
    <div class="row divGrupoInvestigacion"></div>
    <div class="row divEmpresa"> 
        <div class="input-field col s12 m6 l6 ">
            <table style="width: 100%" id="empresasDeTecnoparque_UsosInfraestructuraCreate_table" class="display responsive-table datatable-example DataTable">
              <thead>
                <tr>
                  <th>Nit</th>
                  <th>Nombre de la Empresa</th>
                  <th>Seleccionar</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
          <div class="col s12 m6 l6">
            <h6>La articulación se realizará con la siguiente empresa</h6>
            <div class="card horizontal teal lighten-4">
              <div class="card-stacked">
                <div class="card-content">
                  <div class="input-field col s12 m12 l12">
                    <input type="hidden" name="txtempresa_id" id="txtempresa_id" value="">
                    <input readonly type="text" name="empresa" id="empresa" value="">
                    <label for="empresa">Empresa</label>
                    <small id="txtempresa_id-error" class="error red-text"></small>
                  </div>
                </div>
              </div>
            </div>
          </div>
        
    </div>
    <div class="row divEmprendedor"></div>
</div>

<div class="divider">
</div>

<div class="row">
    <div class="s12 m12 l12">
        <p>
            <i class="material-icons left">
                info_outline
            </i>
            Si no se van a registrar horas de asesorias dejar el campo vacío
        </p>
    </div>
</div>
<div class="row">
    <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">
            book
        </i>
        <input id="txtasesoriadirecta" name="txtasesoriadirecta" type="number"/>
        <label class="active" for="txtasesoriadirecta">
            Asesoria Directa (Horas)
        </label>
        @error('txtasesoriadirecta')
        <label class="error" for="txtasesoriadirecta" id="txtasesoriadirecta-error">
            {{ $message }}
        </label>
        @enderror
    </div>
    <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">
            bookmark
        </i>
        <input id="txtasesoriaindirecta" name="txtasesoriaindirecta" type="number"/>
        <label class="active" for="txtasesoriaindirecta">
            Asesoria Indirecta (Horas)
        </label>
        @error('txtasesoriaindirecta')
        <label class="error" for="txtasesoriaindirecta" id="txtasesoriaindirecta-error">
            {{ $message }}
        </label>
        @enderror
    </div>
</div>
<div class="row">
    <div class="input-field col s12 m12 l8 offset-l2">
        <i class="material-icons prefix">
            create
        </i>
        <textarea class="materialize-textarea" id="txtdescripcion" length="500" name="txtdescripcion">
        </textarea>
        <label for="txtdescripcion">
            Descripción
            <span class="red-text">
                *
            </span>
        </label>
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
                            <select class="select2" disabled="" id="txttalento" name="txttalento" style="width: 100%" tabindex="-1">
                                <option value="">
                                    Seleccione Talento
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
                            <a class="btn-floating btn-large waves-effect waves-light blue lighten-1 tooltipped" data-delay="50" data-position="button" data-tooltip="Agregar Talento" id="btnAgregar" onclick="agregarTalento()">
                                <i class="material-icons">
                                    add
                                </i>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s5 m6 l6">
                            <!-- <i class="material-icons prefix">local_drink</i> -->
                            <select class="select2" id="txtlaboratorio" name="txtlaboratorio" style="width: 100%" tabindex="-1">
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
                            <a class="btn-floating btn-large waves-effect waves-light blue lighten-1 tooltipped" data-delay="50" data-position="button" data-tooltip="Agregar Uso" id="btnAgregar" onclick="agregarLaboratorio()">
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