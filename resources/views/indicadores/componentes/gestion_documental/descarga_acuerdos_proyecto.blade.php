<form id="frmDescargaDeAcuerdos" action="{{route('files.zip.download')}}" method="POST">
    {!! csrf_field() !!}
    <input type="hidden" name="actividad" value="{{App\Models\Proyecto::class}}">
    <input type="hidden" name="archivos" value="{{App\Enums\DescargaArchivos::COMPROMISO}}">
    <div class="row card card-panel teal lighten-5">
        <h6 class="font-bold">Para descargar los acuerdos de confidencialidad y compromiso de proyectos finalizados debe seleccionar un rango de fechas de proyectos finalizados y luego presionar el botón de desarga.</h6>
        @include('indicadores.componentes.gestion_documental.form_descarga_archivo')
    </div>
</form>
