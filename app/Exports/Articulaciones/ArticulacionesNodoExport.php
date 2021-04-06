<?php

namespace App\Exports\Articulaciones;

use Illuminate\Contracts\View\View;
use App\Exports\FatherExport;
use Maatwebsite\Excel\Concerns\{FromView, ShouldAutoSize, WithTitle, WithEvents};
use Maatwebsite\Excel\Events\AfterSheet;
use App\Repositories\Repository\ArticulacionRepository;


// use Maatwebsite\Excel\Concerns\FromCollection;

class ArticulacionesNodoExport extends FatherExport implements FromView, ShouldAutoSize, WithTitle, WithEvents
{

    private $rticulacionRepository;
    private $id;

    public function __construct(ArticulacionRepository $articulacionRepository, $id)
    {
        $this->articulacionRepository = $articulacionRepository;
        $this->id = $id;
        $this->query = $this->articulacionRepository->consultarArticulacionesDeUnNodo( $this->id );
        $this->setCount($this->query->count() + 1);
        $this->setRangeBodyCell('A1:P'.$this->getCount());
    }

    public function view(): View
    {
        $query = $this->query;
        return view('exports.articulacion.nodo', [
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
            $event->sheet->mergeCells('A1:P6');
            $event->sheet->getStyle($this->getRangeHeadingCell())->applyFromArray($this->styleArray())->getFont()->setSize(14)->setBold(1);
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
        return 'Articulaciones';
    }
}
