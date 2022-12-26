<div class="center-align">
    <span class="card-title center-align primary-text"><b>Proyecto -
            {{ $proyecto->present()->proyectoCode() }}</b></span>
</div>
<div class="divider"></div>
<div class="card bg-info">
    <div class="row no-m-t no-m-b">
        <div class="col s12 m12">
            <div class="card-content white-text center-align">
                <h5><i class="material-icons center-align">
                        info_outline
                    </i>
                    Este proyecto se encuentra actualmente en fase de {{ $proyecto->fase->nombre }}
                </h5>
            </div>
        </div>
    </div>
</div>
