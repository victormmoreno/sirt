<?php

namespace App\Exports\Articulaciones;

use Illuminate\Contracts\View\View;
use App\Models\Articulacion;
use App\Exports\FatherExport;
use Maatwebsite\Excel\Concerns\{FromView, ShouldAutoSize, WithTitle, WithEvents, WithDrawings};
use Maatwebsite\Excel\Events\{AfterSheet};
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use App\Repositories\Repository\{ArticulacionRepository, GrupoInvestigacionRepository, EmpresaRepository, ArticulacionProyectoRepository};

class ArticulacionesUnicaExport extends FatherExport implements FromView, ShouldAutoSize, WithTitle, WithEvents, WithDrawings
{

  private $articulacionProyectoRepository;
  private $grupoInvestigacionRepository;
  private $articulacionRepository;
  private $empresaRepository;
  private $entidad;
  private $object;

  public function __construct(ArticulacionRepository $articulacionRepository, $id, $query, ArticulacionProyectoRepository $articulacionProyectoRepository, GrupoInvestigacionRepository $grupoInvestigacionRepository, EmpresaRepository $empresaRepository)
  {
    $this->articulacionProyectoRepository = $articulacionProyectoRepository;
    $this->grupoInvestigacionRepository = $grupoInvestigacionRepository;
    $this->articulacionRepository = $articulacionRepository;
    $this->empresaRepository = $empresaRepository;
    $this->id = $id;
    $this->setQuery($query);
    $this->setCount(2);
    $this->setRangeHeadingCell('A7:P7');
    $this->setRangeBodyCell('A7:P8');
    $this->setObject(Articulacion::find($id));


    $entidad = null;
    if ($this->getObject()->tipo_articulacion == Articulacion::IsEmpresa()) {
      $entidad = $this->empresaRepository->consultarDetallesDeUnaEmpresa($this->getObject()->articulacion_proyecto->entidad->empresa->id)->toArray();
    } else if ($this->getObject()->tipo_articulacion == Articulacion::IsGrupo()) {
      $entidad = $this->grupoInvestigacionRepository->consultarDetalleDeUnGrupoDeInvestigacion($this->getObject()->articulacion_proyecto->entidad->grupoinvestigacion->id)->toArray();
    } else {
      $entidad = $this->articulacionProyectoRepository->consultarTalentosDeUnaArticulacionProyectoRepository($this->getObject()->articulacion_proyecto->id);
    }
    $this->setEntidad($entidad);
  }

  /**
   * Asigna el objeto de articulacion
   * @param object $object
   * @return void
   * @author dum
   */
  private function setObject($object)
  {
    $this->object = $object;
  }

  /**
  * Retorna el valor del object
  * @return object
  * @author dum
  */
  public function getObject()
  {
    return $this->object;
  }

  /**
   * Asignar un valor a entidad
   * @param object $entidad
   * @return void
   * @author dum
   */
  private function setEntidad($entidad) {
    $this->entidad = $entidad;
  }

  /**
   * Obtiene el valor de la entidad
   * @return object
   * @author dum
   */
  public function getEntidad()
  {
    return $this->entidad;
  }

  public function view(): View
  {
    $query = $this->getQuery();
    return view('exports.articulacion.id', [
      'articulacion' => $query
    ]);
  }

  /**
  * Método para aplicar estilos al archivo excel después de que se genera la hoja de excel
  * @return array
  * @author dum
  */
  public function registerEvents(): array
  {
    $columnPar = $this->styleArrayColumnsPar();
    $columnImPar = $this->styleArrayColumnsImPar();
    $styles = array('pares' => $columnPar, 'impares' => $columnImPar);
    return [
      AfterSheet::class => function(AfterSheet $event) use ($styles) {
        $event->sheet->getStyle($this->getRangeHeadingCell())->applyFromArray($this->styleArray())->getFont()->setSize(14)->setBold(1);
        $event->sheet->getStyle($this->getRangeBodyCell())->applyFromArray($this->styleArray());

        $event->sheet->mergeCells('A1:B6');

        if ( $this->getQuery()->tipo_articulacion == 'Grupo de Investigación' ) {
          $event->sheet->mergeCells('D2:G2');
          $event->sheet->mergeCells('C1:C6');
          $event->sheet->mergeCells('D1:G1');
          $event->sheet->mergeCells('D5:G6');
          $event->sheet->mergeCells('H1:P6');
          $event->sheet->getStyle('D2:G4')->applyFromArray($styles['pares']);
          $event->sheet->getStyle('D2:G4')->applyFromArray($this->styleArray());
          $event->sheet->setCellValue('D3', 'Código del Grupo de Investigación')->getStyle('D3')->getFont()->setBold(1);
          $event->sheet->setCellValue('E3', 'Nombre del Grupo de Investigación')->getStyle('E3')->getFont()->setBold(1);
          $event->sheet->setCellValue('F3', 'Institución')->getStyle('F3')->getFont()->setBold(1);
          $event->sheet->setCellValue('G3', 'Clasificación ColCiencias')->getStyle('G3')->getFont()->setBold(1);
          $event->sheet->setCellValue('D4', $this->getEntidad()['codigo_grupo']);
          $event->sheet->setCellValue('E4', $this->getEntidad()['nombre_grupo']);
          $event->sheet->setCellValue('F4', $this->getEntidad()['institucion']);
          $event->sheet->setCellValue('G4', $this->getEntidad()['nombre_clasificacion']);
          $event->sheet->getStyle('D2:G3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        } else if ( $this->getQuery()->tipo_articulacion == 'Empresa' ) {
          $event->sheet->mergeCells('D2:E2');
          $event->sheet->mergeCells('D1:E1');
          $event->sheet->mergeCells('C1:C6');
          $event->sheet->mergeCells('D5:E6');
          $event->sheet->mergeCells('F1:P6');
          $event->sheet->getStyle('D2:E4')->applyFromArray($styles['impares']);
          $event->sheet->getStyle('D2:E4')->applyFromArray($this->styleArray());
          $event->sheet->setCellValue('D2', $this->getQuery()->tipo_articulacion)->getStyle('D2')->getFont()->setBold(1);
          $event->sheet->setCellValue('D3', 'Nit de la Empresa')->getStyle('D3')->getFont()->setBold(1);
          $event->sheet->setCellValue('E3', 'Nombre de la Empresa')->getStyle('E3')->getFont()->setBold(1);
          $event->sheet->setCellValue('D4', $this->getEntidad()['nit']);
          $event->sheet->setCellValue('E4', $this->getEntidad()['nombre_empresa']);
          $event->sheet->getStyle('D2:E3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        } else {
          $event->sheet->mergeCells('C1:P6');
          $event->sheet->mergeCells('D11:F11');
          $event->sheet->setCellValue('D11', $this->getQuery()->tipo_articulacion)->getStyle('D11')->getFont()->setBold(1);
          $event->sheet->setCellValue('D12', 'Rol')->getStyle('D12')->getFont()->setBold(1);
          $event->sheet->setCellValue('E12', 'Documento de Identidad')->getStyle('E12')->getFont()->setBold(1);
          $event->sheet->setCellValue('F12', 'Nombre')->getStyle('F12')->getFont()->setBold(1);
          $event->sheet->getStyle('D11:F12')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
          $row = 0;
          $inicio = 13;
          foreach ($this->getEntidad() as $key => $value) {
            $row = $inicio + $key;
            $event->sheet->setCellValue('D'.$row, $value->rol);
            $event->sheet->setCellValue('E'.$row, $value->documento);
            $event->sheet->setCellValue('F'.$row, $value->nombre_talento);
          }
          $event->sheet->getStyle('D11:F'.$row)->applyFromArray($styles['pares']);
          $event->sheet->getStyle('D11:F'.$row)->applyFromArray($this->styleArray());
        }
        $event->sheet->getStyle('A7:A8')->applyFromArray($styles['pares']);
        $event->sheet->getStyle('B7:B8')->applyFromArray($styles['impares']);
        $event->sheet->getStyle('C7:C8')->applyFromArray($styles['pares']);
        $event->sheet->getStyle('D7:D8')->applyFromArray($styles['impares']);
        $event->sheet->getStyle('E7:E8')->applyFromArray($styles['pares']);
        $event->sheet->getStyle('F7:F8')->applyFromArray($styles['impares']);
        $event->sheet->getStyle('G7:G8')->applyFromArray($styles['pares']);
        $event->sheet->getStyle('H7:H8')->applyFromArray($styles['impares']);
        $event->sheet->getStyle('I7:I8')->applyFromArray($styles['pares']);
        $event->sheet->getStyle('J7:J8')->applyFromArray($styles['impares']);
        $event->sheet->getStyle('K7:K8')->applyFromArray($styles['pares']);
        $event->sheet->getStyle('L7:L8')->applyFromArray($styles['impares']);
        $event->sheet->getStyle('M7:M8')->applyFromArray($styles['pares']);
        $event->sheet->getStyle('N7:N8')->applyFromArray($styles['impares']);
        $event->sheet->getStyle('O7:O8')->applyFromArray($styles['pares']);
        $event->sheet->getStyle('P7:P8')->applyFromArray($styles['impares']);
      },
    ];
  }

  /**
  * Asigna el nombre para la hoja de excel
  * @return string
  * @author dum
  */
  public function title(): String
  {
    return 'Articulacion ' . $this->getQuery()->codigo_articulacion;
  }

  /**
  * Método para pinta imágenes en el archivo de Excel
  * @return object
  * @author dum
  */
  public function drawings()
  {
    $drawing = new Drawing();
    $drawing->setName('Logo');
    $drawing->setDescription('This is my logo');
    $drawing->setPath(public_path('/img/logonacional_Negro.png'));
    $drawing->setResizeProportional(false);
    $drawing->setHeight(104);
    $drawing->setWidth(120);
    $drawing->setCoordinates('A1');
    return $drawing;
  }

}
