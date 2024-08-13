<form id="frmDescargaDeActasCierre" action="{{route('files.zip.download')}}" method="POST">
    {!! csrf_field() !!}
    <input type="hidden" name="actividad" value="{{App\Models\Proyecto::class}}">
    <input type="hidden" name="archivos" value="{{App\Enums\DescargaArchivos::CIERRE}}">
    <div class="row card card-panel teal lighten-5">
        <h6 class="font-bold">Para descargar las actas de cierre de proyectos finalizados debe seleccionar un rango de fechas de proyectos finalizados y luego presionar el botón de desarga.</h6>
        @include('indicadores.componentes.gestion_documental.form_descarga_archivo')
    </div>
</form>
