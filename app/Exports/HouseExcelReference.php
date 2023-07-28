<?php

namespace App\Exports;

use Illuminate\Contracts\Support\Responsable;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection; //For larage data execute in chunks
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
// Heading Style
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterSheet;

use App\Models\Area;
use App\Models\Type;

class HouseExcelReference implements 
FromCollection,
Responsable, 
ShouldAutoSize,
WithHeadings,
WithEvents
{
    use Exportable;
    private $fileName = "HouseDetReference.xlsx";
    private $collection;
    public function __construct($arrays)
    {
        $this->collection = collect($arrays);
    }

    public function collection()
    {
        // $test=[
        //     ['area'=>'Prashanti Vihar', 'city'=>'bbsr', 'type'=>'1 BHK'],
        //     ['area'=>'Prashanti Vihar', 'city'=>'bbsr', 'type'=>'1 BHK'],
        //     ['area'=>'Prashanti Vihar', 'city'=>'bbsr', 'type'=>'1 BHK'],
        //     ['area'=>'', 'city'=>'', 'type'=>'1 BHK']
        // ];
        // echo'<pre>'; print_r($test);
        // $test1 = collect($test);
        // return $test1;

        return $this->collection;
        
    }
    
    public function headings(): array
    {
        return[
            'Area', 'City','Type'
        ];
    }

    public function registerEvents(): array
    {
        return
        [
            AfterSheet::class => function(AfterSheet $event){
                $event->sheet->getStyle('A1:C1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
                    ], 
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                        'rotation' => 90,
                        'startColor' => [
                            'argb' => 'FFA0A0A0',
                        ],
                        'endColor' => [
                            'argb' => 'FFFFFFFF',
                        ],
                    ],
                ]);
            }
        ];
    }
}
