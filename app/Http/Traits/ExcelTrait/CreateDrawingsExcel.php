<?php

namespace App\Http\Traits\ExcelTrait;

use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

trait CreateDrawingsExcel
{
    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo Tecnoparque');
        $drawing->setPath(public_path('/img/logonacional_Negro.png'));
        $drawing->setResizeProportional(false);
        $drawing->setHeight(90);
        $drawing->setWidth(300);
        $drawing->setCoordinates('B2');

        $drawing2 = new Drawing();
        $drawing2->setName('Logo Sennova');
        $drawing2->setPath(public_path('/img/sennova.png'));
        $drawing2->setResizeProportional(false);
        $drawing2->setHeight(90);
        $drawing2->setWidth(300);
        $drawing2->setCoordinates('K2');
        return [$drawing, $drawing2];
    }
}
