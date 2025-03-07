<div class="modal modal modal-fixed-footer" id="filter_project_advanced_modal">
    <div class="modal-content">
        <div class="row">
            <div class="col s12 m12 l12">
                <span class=" mailbox-title title primary-text">
                    Proyectos Finalizados Tecnoparque {{ \NodoHelper::returnNameNodoUsuario() }}
                </span>
                <div class="row search-tabs-row search-tabs-header">
                    <div class="input-field col s12 m2 l2">
                        <label class="active" for="filter_year_pro">Año <span class="red-text">*</span></label>
                        <select name="filter_year_pro" id="filter_year_pro">
                            @for ($i=$year; $i >= 2016; $i--)
                                <option value="{{$i}}" >{{$i}}</option>
                            @endfor
                            <option value="all" >todos</option>
                        </select>
                    </div>

                    <div class="col s12 m6 l4 offset-m3 right">
                        <button class="waves-effect waves-light btn bg-primary white-text m-b-xs search-tabs-button right" id="filter_project_modal"><i class="material-icons">search</i>Filtrar</button>
                    </div>
                </div>
                <div class="row search-tabs-row search-tabs-header">
                </div>
                <table id="datatable_projects_finalizados" class="display responsive-table datatable-example dataTable" style="width: 100%">
                    <thead class="bg-primary white-text">
                        <tr>
                            <th>Código de Proyecto</th>
                            <th>Nombre</th>
                            <th>Fase</th>
                            <th>Seleccionar</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-primary btn-flat">Cerrar</a>
    </div>
</div>
