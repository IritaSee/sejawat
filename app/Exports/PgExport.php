<?php

namespace App\Exports;

use App\Models\Ujian;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Color;

class PgExport implements FromView, ShouldAutoSize, WithStyles
{

    public function __construct($data)
    {
        $this->data = $data;
    }


    public function styles(Worksheet $sheet)
    {
        $akhir = (count($this->data->waktuujian) + 1);

        $sheet->getStyle('A1:F1')->applyFromArray([
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'FFFF00'],
            ],
        ]);

        $sheet->getStyle('A1:F1')->getFont()->setBold(true);
        $sheet->getStyle("A1:F$akhir")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => [
                        'rgb' => '000000'
                    ]
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
    }


    public function view(): View
    {
        return view('ekspor.nilai-ujian', [
            'ujian' => $this->data
        ]);
    }
}
