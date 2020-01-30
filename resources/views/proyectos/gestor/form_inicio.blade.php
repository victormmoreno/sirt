<form id="frmProyectosCreate" action="{{route('proyecto.store')}}" method="POST">
    {!! csrf_field() !!}
    <div class="row">
        <div class="input-field col s12 m6 l6">
            <input disabled id="txtgestor" name="txtgestor" value="{{ auth()->user()->nombres }} {{ auth()->user()->apellidos }}" type="text">
            <label for="txtgestor" class="">Gestor</label>
        </div>
        <div class="input-field col s12 m6 l6">
            <input disabled id="txtlinea" name="txtlinea" value="{{ auth()->user()->gestor->lineatecnologica->nombre }}" type="text">
            <label for="txtlinea" class="">Línea Tecnológica</label>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m6 l6 offset-l3 m3">
            <center>
                <div class="card-panel grey lighten-3">
                    <div class="row">
                        <div class="input-field col s12 m12 l12">
                            <input type="text" id="txtnombreIdeaProyecto_Proyecto" name="txtnombreIdeaProyecto_Proyecto" readonly>
                            <label for="txtnombreIdeaProyecto_Proyecto">Idea de Proyecto</label>
                            <small id="txtidea_id-error" class="error red-text"></small>
                        </div>
                        <a class="btn-floating blue" onclick="consultarIdeasDeProyectoDelNodo();"><i class="material-icons left">search</i>Buscar</a>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m12 l12">
                            <input type="text" id="txtnombre" name="txtnombre">
                            <label for="txtnombre">Nombre de Proyecto <span class="red-text">*</span></label>
                            <small id="txtnombre-error" class="error red-text"></small>
                        </div>
                    </div>
                </div>
            </center>
            <input type="hidden" name="txtidea_id" id="txtidea_id" value="">
        </div>
    </div>
    <div class="row">
        <div class="col s12 m6 l6">
            <p class="card-title">TRL que se pretende realizar <span class="red-text">*</span></p><br>
            <div class="input-field col s12 m12 l12">
                <p class="p-v-xs">
                    <input class="with-gap" name="posible_trl" type="radio" id="TRL6" value="0" />
                    <label for="TRL6">TRL 6</label>
                    <input class="with-gap" name="posible_trl" type="radio" id="TRL7_8" value="1" />
                    <label for="TRL7_8">TRL 7 - TRL 8</label>
                </p>
                <small id="posible_trl-error" class="center-align error red-text"></small>
            </div>
        </div>

    </div>
</form>