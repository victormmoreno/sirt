<div class="section-company" style="display: none;">
    <div class="row search-tabs-row search-tabs-header">
        <h5><b>Seleccione la sede de la empresa</b></h5>
        <div class="input-field col s12 m12 l4">
            <input type="text" id="filter_nit" name="filter_nit" class="autocomplete">
            <label for="filter_nit">Nit Empresa</label>
        </div>
        <div class="input-field col s12 m12 l8 right">
            <a class="waves-effect waves-grey btn-flat search-tabs-button right" id="filter_company_advanced"><i class="material-icons">list</i>Busqueda Avanzada</a>
            <a class="waves-effect waves-grey btn-flat search-tabs-button right" id="filter_company"><i class="material-icons">search</i>Buscar</a>
        </div>
    </div>
    <div class="row search-tabs-row search-tabs-container grey lighten-4">
        <div class="col s12 m6 l6">
            <div class="mailbox-options grey lighten-4">
                <ul class="grey lighten-4">
                    <li class="text-mailbox">Sedes de la empresa</li>
                </ul>
            </div>
        </div>
        <div class="col s12 m6 l6 right-align search-stats">
            <span class="m-r-sm">Resultados</span><span class="secondary-stats"></span>
        </div>
    </div>
    <div class="row search-tabs-row search-tabs-container white lighten-4 result-companies">
        <div class="col s12 m12 l12">
            <div class="card card-transparent p f-12 m-t-lg">
                <div class="card-content">
                    <span class="card-title p-h-lg  p f-12">Aún no has seleccionado la empresa</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row search-tabs-row search-tabs-container grey lighten-4">
        <div class="col s12 m12 l12">
            <div class="mailbox-options grey lighten-4 text-white">
                <ul class="grey lighten-4 text-white result-sede">
                    <li class="text-mailbox ">Sede que participará en la articulación</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row search-tabs-row search-tabs-container white lighten-4 result-sedes container-error">
        <div class="col s12 m12 l12">
            <div class="card card-transparent p f-12 m-t-lg">
                <div class="card-content">
                    <span class="card-title p-h-lg  p f-12">Aún no has seleccionado la sede</span>
                    <input type="hidden" name="sedes" id="sedes"/>
                </div>
            </div>
        </div>
    </div>
</div>
