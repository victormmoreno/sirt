<div class="row">
    <div class="col s12 m12 l12">
        <div class="card-content">
            <ul class="collapsible collapsible-accordion" data-collapsible="accordion">
                <li>
                    <div class="collapsible-header active blue-grey lighten-1"><i class="material-icons">people</i>
                        Pulse aquí para ver la información de los talentos.
                    </div>
                    <div class="collapsible-body">
                        <div class="card-content">
                            <ul class="collapsible collapsible-accordion" data-collapsible="accordion">
                                <li>
                                    <div class="collapsible-header cyan lighten-1"><i class="material-icons">group_add</i>
                                        Pulse aquí para ver los talentos y asociarlos al proyecto.</div>
                                    <div class="collapsible-body">

                                        <div class="card-content">
                                            <div class="row">
                                                <table id="talentosDeTecnoparque_Proyecto_FaseInicio_table" style="width: 100%">
                                                    <thead>
                                                        <th>Documento de Identidad</th>
                                                        <th>Nombres del Talento</th>
                                                        <th>Asociar al Proyecto</th>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <ul class="collapsible collapsible-accordion" data-collapsible="accordion">
                                <li>
                                    <div class="collapsible-header active green lighten-1"><i class="material-icons">how_to_reg</i>
                                        Pulse aquí para la información de los talentos asociados al proyecto.
                                    </div>
                                    <div class="collapsible-body">

                                        <div class="card-content">
                                            <div class="row">
                                                <table id="detalleTalentosDeUnProyecto_Create" class="striped">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 15%">Talento Interlocutor</th>
                                                            <th style="width: 40%">Talento</th>
                                                            <th style="width: 20%">Eliminar</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                            @foreach ($proyecto->talentos as $key => $value)
                                                                <tr id="talentoAsociadoAProyecto{{$value->id}}">
                                                                <td><input type="radio" class="with-gap" {{$value->pivot->talento_lider == 1 ? 'checked' : ''}} name="radioTalentoLider" id="radioButton'{{$value->id}}'" value="{{$value->id}}"/><label for ="radioButton'{{$value->id}}'"></label></td>
                                                                <td><input type="hidden" name="talentos[]" value="{{$value->id}}">{{$value->documento}} - {{$value->nombres}} {{$value->apellidos}}</td>
                                                                <td><a class="waves-effect bg-danger white-text btn" onclick="eliminarTalentoDeProyecto_FaseInicio({{$value->id}});"><i class="material-icons">delete_sweep</i></a></td>
                                                                </tr>
                                                            @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div id="talentos-error" class="error red-text"></div>
                                            <div id="radioTalentoLider-error" class="error red-text"></div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
