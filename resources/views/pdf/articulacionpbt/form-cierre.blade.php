<!doctype html>
<html lang="es">
  <head>
    <style>
      footer.page-footer {
      margin-top: 20px;
      padding-top: 20px;
      background-color: #ee6e73;
    }

    footer.page-footer .footer-copyright {
      overflow: hidden;
      height: 50px;
      line-height: 50px;
      color: rgba(255, 255, 255, 0.8);
      background-color: rgba(51, 51, 51, 0.08);
    }

.center-image{
  vertical-align: middle;
  width: 45px;
  height: 45px;
  border-radius: 50%;
  margin-left: 10px;

}

table, th, td {
  border: solid;
}

table {
  width: 100%;
  display: table;
  font-size: 13px;
}

table.bordered > thead > tr,
table.bordered > tbody > tr {
  border-bottom: 2px solid #050505;
}

table.striped > tbody > tr:nth-child(odd) {
  background-color: #f2f2f2;
}

table.striped > tbody > tr > td {
  border-radius: 0;
}

table.highlight > tbody > tr {
  transition: background-color .25s ease;
}

table.highlight > tbody > tr:hover {
  background-color: #f2f2f2;
}

table.centered thead tr th, table.centered tbody tr td {
  text-align: center;
}

thead {
  border-bottom: 1px solid #d0d0d0;
}

td, th {

  display: table-cell;
  text-align: left;
  vertical-align: middle;
  border-radius: 2px;
  overflow: hidden;
  white-space: pre-line;

}
.centered {
  text-align: center;
}
@media only screen and (max-width: 992px) {
  table.responsive-table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
    display: block;
    position: relative;
    /* sort out borders */
  }
  table.responsive-table td:empty:before {
    content: '\00a0';
  }
  table.responsive-table th,
  table.responsive-table td {
   
    vertical-align: top;
  }
  table.responsive-table th {
    text-align: left;
  }
  table.responsive-table thead {
    display: block;
    float: left;
  }
  table.responsive-table thead tr {
    display: block;
    padding: 0 0 0 0;
  }
  table.responsive-table thead tr th::before {
    content: "\00a0";
  }
  table.responsive-table tbody {
    display: block;
    width: auto;
    position: relative;
    overflow-x: auto;
    white-space: nowrap;
  }
  table.responsive-table tbody tr {
    display: inline-block;
    vertical-align: top;
  }
  table.responsive-table th {
    display: block;
    text-align: right;
  }
  table.responsive-table td {
    display: block;
    min-height: 1.25em;
    text-align: left;
  }
  table.responsive-table tr {
    padding: 0 0px;
  }
  table.responsive-table thead {
    border: 0;
    border-right: 1px solid #d0d0d0;
  }
  table.responsive-table.bordered th {
    border-bottom: 0;
    border-left: 0;

  }
  table.responsive-table.bordered td {
    border-left: 0;
    border-right: 0;
    border-bottom: 0;
    border: 1px solid #000;
  
  }
  table.responsive-table.bordered tr {
    border: 0;
  }
  table.responsive-table.bordered tbody tr {
    border-right: 1px solid #d0d0d0;
    min-width: 235px;
    height: 10px;
    background-color: #433;
  }

  td{
    text-align: center;
  padding: 5px;
  /* Alto de las celdas */
  height: 10px;
  }

  .tr-striped {
       background-color: #bdbdbd;
      }

  
}

    </style>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Acta de Cierre</title>
  </head>
  
  <body>
    <footer>
        GD-F-007 V01
    </footer>
    <div class="card-content">
      <table class="bordered">
        <tr>
          <td colspan="1" rowspan="2"><img class="center-image" src="{{asset('img/web.png')}}"></td>
          <td colspan="5" class="centered"><b>Acta de Cierre<b></td>
        </tr>
        <tr>
          <td colspan="5" class="centered"><b>ACTA No. {{ substr($articulacion->actividad->codigo_actividad, -4) . "-" . Carbon\Carbon::now()->isoFormat('YYYY-MM-DD') }}<b></td>
        </tr>     
      </table>
      <br>
      <table class="bordered">
        <tr class="tr-striped">
          <td colspan="6" ><b>Información general<b></td>
        </tr>
        <tr>
          <td><b>Código Articulación<b></td>
          <td colspan="3">{{$articulacion->actividad->codigo_actividad}}</td>
          <td><b>Tipo Convocatoria</b></td>
          <td>{{$articulacion->present()->articulacionPbtNameTipoVinculacion()}}</td>
        </tr>
        <tr>
          <td><b>Nombre Articulación</b></td>
          <td colspan="5">{{$articulacion->actividad->nombre}}</td>
        </tr>
        <tr>
          <td><b>Nodo</b></td>
          <td>{{$articulacion->actividad->nodo->entidad->nombre}}</td>
          <td><b>Fecha</b></td>
          <td>{{$articulacion->actividad->fecha_inicio->isoFormat('DD-MM-YYYY')}}</td>
          <td><b>Fecha esperada de finalización</b></td>
          <td>{{$articulacion->present()->articulacionPbtFechaFinalizacion()}}</td>
        </tr>
        <tr>
          <td><b>Tipo Articulacion</b></td>
          <td colspan="2">{{$articulacion->present()->articulacionPbtNombreTipoArticulacion()}}</td>
          <td><b>Alcance</b></td>
          <td colspan="2">{{$articulacion->present()->articulacionPbtNombreAlcanceArticulacion()}}</td>
        </tr>
        
        <tr>
          <td colspan="2"><b>Entidad con la que se realiza la articulación</b></td>
          <td colspan="4">{{$articulacion->present()->articulacionPbtEntidad()}}</td>
        </tr>
        <tr>
          <td><b>Correo institucional de la entidad</b></td>
          <td colspan="2">{{$articulacion->present()->articulacionPbtEmail()}}</td>
          <td><b>Nombre de contacto</b></td>
          <td colspan="2">{{$articulacion->present()->articulacionPbtNombreContacto()}}</td>
        </tr>
        <tr>
          <td colspan="2"><b>Nombre de la convocatoria</b></td>
          <td colspan="4">{{$articulacion->present()->articulacionPbtNombreConvocatoria()}}</td>
        </tr>
        <tr>
          <td colspan="1"><b>Objetivo</b></td>
          <td colspan="5">{{$articulacion->present()->articulacionPbtObjetivo()}}</td>
        </tr>
        
        @if($articulacion->present()->articulacionPbtPostulacion() == 0)
        <tr>
          <td colspan="1"><b>Justificación</b></td>
          <td colspan="5"> {{$articulacion->present()->articulacionPbtJustificacion()}}</td>
        </tr>
        @elseif($articulacion->present()->articulacionPbtPostulacion() == 1)
            
          @if($articulacion->present()->articulacionPbtAprobacion() == 1)
            <tr>
              <td colspan="1"><b>Qué recibirá</b></td>
              <td colspan="5">{{$articulacion->present()->articulacionPbtRecibira()}}</td>
            </tr>
            <tr>
              <td colspan="2"><b>Cuando</b></td>
              <td colspan="4">{{$articulacion->present()->articulacionPbtFechaCuando()}}</td>
            </tr>
          @endif
          
        @endif
        <tr>
          <td colspan="1"><b>Lecciones aprendidas</b></td>
          <td colspan="5">{{$articulacion->present()->articulacionPbtLeccionesAprendidas()}}</td>
        </tr>
        @if($articulacion->present()->articulacionPbtTipoVinculacion(App\Models\ArticulacionPbt::IsPbt()))
          <tr class="tr-striped">
            <td colspan="6" ><b>Información Proyecto de Base Tecnológica (PBT)<b></td>
          </tr>
          <tr>
            <td colspan="1"><b>Código Idea<b></td>
            <td colspan="2">{{$articulacion->present()->articulacionPbtCodeIdeaProyecto()}}</td>
            <td colspan="1"><b>Nombre Idea</b></td>
            <td colspan="2">{{$articulacion->present()->articulacionPbtNameIdeaProyecto()}}</td>
          </tr>
          <tr>
            <td colspan="1"><b>Código Proyecto<b></td>
            <td colspan="2">{{$articulacion->present()->articulacionPbtCodeProyecto()}}</td>
            <td colspan="1"><b>Nombre Proyecto</b></td>
            <td colspan="2">{{$articulacion->present()->articulacionPbtNameProyecto()}}</td>
          </tr>        
        @endif
        <tr class="tr-striped">
          <td colspan="6" ><b>Talentos que participan de la articulación<b></td>
        </tr>
        <tr>
            <td colspan="1"><b> Interlocutor</b></td>
            <td colspan="5"><b>Talento</b></td>
        </tr>
        @forelse ($articulacion->talentos as $talento)
        <tr>
          @if($talento->pivot->talento_lider == 1)
            <td colspan="1" >SI</td>
          @else
          <td colspan="1" >NO</td>
          @endif
          
          <td colspan="5" >{{$talento->user->documento}} - {{$talento->user->nombres}} {{$talento->user->apellidos}}</td>
        </tr>
        @empty
        <tr>
          <td colspan="1" >Sin resultados</td>
          <td colspan="5" >Sin resultados</td>
        </tr>
        @endforelse
        <tr class="tr-striped">
            <td colspan="6" ><b>Certificación del Talento Interlocutor y Articulador Asesor<b></td>
        </tr>
        <tr>
          <td colspan="6" rowspan="5"></td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr>
          <td colspan="6" >{{$articulacion->present()->fullNameTalentInterlocutor()}} - Talento Interlocutor</td>
        </tr>
        <tr>
          <td colspan="6" rowspan="5"></td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr>
          <td colspan="6" >{{$articulacion->actividad->present()->actividadUserAsesor()}} - Articulador</td>
        </tr>
      </table>
  </div>
  </body>
</html>