<li class="active">
    <div class="collapsible-header active">
        <i class="material-icons">edit</i>Proyectos
    </div>
    <div class="collapsible-body" style="display: block;">
        <div class="row card card-panel">
            <div class="col s12 m4 l4">
                <div class="row">
                <div class="input-field col s12 m3 l3">
                    <select class="js-states" tabindex="-1" style="width: 100%" id="txtanho_proyectos" name="txtanho_proyectos" onchange="consultarProyectosDelGestor_costos(this.value);">
                    {!! $year = Carbon\Carbon::now(); $year = $year->isoFormat('YYYY'); !!}
                    @for ($i=2016; $i <= $year; $i++)
                        <option value="{{$i}}" {{ $i == Carbon\Carbon::now()->isoFormat('YYYY') ? 'selected' : '' }}>{{$i}}</option>
                    @endfor
                    </select>
                    <label for="txtanho_proyectos">Seleccione el Año</label>
                </div>
                <div class="input-field col s12 m9 l9">
                    <select id="txtactividad_id" name="txtactividad_id" style="width: 100%" class="js-states select2 browser-default">
                        <option value="">Seleccione un proyecto</option>
                        @forelse ($projects as $id => $name)
                            <option value="{{$id}}">{{$name}}</option>
                        @empty
                            <option value="">No hay información disponible</option>
                        @endforelse
                    </select>
                    <label for="txtactividad_id" class="active">Seleccione un proyecto</label>
                </div>
                <div class="input-field col s12 m12 l12">
                    <input type="text" name="txtlinea_actividad" id="txtlinea_actividad" disabled>
                    <label for="txtlinea_actividad">Línea Tecnológica</label>
                </div>
                <div class="input-field col s12 m12 l12">
                    <input type="text" name="txtgestor_actividad" id="txtgestor_actividad" disabled>
                    <label for="txtgestor_actividad">Experto</label>
                </div>
                <div class="input-field col s12 m12 l12">
                    <input type="text" name="txthoras_asesoria_actividad" id="txthoras_asesoria_actividad" disabled>
                    <label for="txthoras_asesoria_actividad">Horas de Asesoria en Proyecto</label>
                </div>
                <div class="input-field col s12 m12 l12">
                    <input type="text" name="txthoras_uso_actividad" id="txthoras_uso_actividad" disabled>
                    <label for="txthoras_uso_actividad">Horas de Uso de Equipos en Proyecto</label>
                </div>
                <div class="input-field col s12 m12 l12">
                    <input type="text" name="txtcosto_asesorias_actividad" id="txtcosto_asesorias_actividad" disabled>
                    <label for="txtcosto_asesorias_actividad">Costo de Asesoría en Proyecto</label>
                </div>
                <div class="input-field col s12 m12 l12">
                    <input type="text" name="txtcostos_equipos_actividad" id="txtcostos_equipos_actividad" disabled>
                    <label for="txtcostos_equipos_actividad">Costo de Equipos en Proyecto</label>
                </div>
                <div class="input-field col s12 m12 l12">
                    <input type="text" name="txtcostos_materiales_actividad" id="txtcostos_materiales_actividad" disabled>
                    <label for="txtcostos_materiales_actividad">Costos de Materiales en Proyecto</label>
                </div>
                <div class="input-field col s12 m12 l12">
                    <input type="text" name="txtcostos_administrativos_actividad" id="txtcostos_administrativos_actividad" disabled>
                    <label for="txtcostos_administrativos_actividad">Costos Administrativos en Proyecto</label>
                </div>
                <div class="input-field col s12 m12 l12">
                    <input type="text" name="txtcosto_total_actividad" id="txtcosto_total_actividad" disabled>
                    <label for="txtcosto_total_actividad">Total Costos</label>
                </div>
                </div>
                <div class="divider"></div>
                <div class="row">
                <center>
                    <button onclick="consultarCostoDeUnaActividad()" class="btn">Consultar</button>
                </center>
                </div>
            </div>
            <div class="col s12 m8 l8">
                <div id="costosDeUnProyecto_column" class="green lighten-3" >
                <div class="row card-panel">
                    <h5 class="center">
                    Para consultar el costo de un proyecto, debes seleccionar un proyecto en el campo de proyectos y luego pulsar el botón de consultar.
                    </h5>
                </div>
                </div>
            </div>
        </div>
    </div>
</li>
