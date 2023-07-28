<?php

namespace App\Exports;

use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection; //For small data
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
// Multisheet
// use Maatwebsite\Excel\Concerns\WithMultipleSheets;
// Models
use App\Models\House;

class HouseExcelTemplate implements 
// FromCollection, 
Responsable, 
ShouldAutoSize, 
// WithMapping, 
WithHeadings, 
WithEvents
{
    use Exportable;
    private $fileName = "HouseDetailsTemplate.xlsx";
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     $house = House::with('user:email,id','city:city_name,id','area:area_name,id','type:type,id')
    //     ->select("id", "advance","city_id", "area_id", "type_id", "rent", "from_date", "contact_no", "detailed_address", "image", "status", "created_by")
    //     ->where('from_date','>', date("Y-m-d")) 
    //     ->get(); 
    //     return $house;
    // }

    // public function map($house): array
    // {
    //     return[
    //         $house->area->area_name,
    //         $house->city->city_name,
    //         $house->type->type,
    //         $house->from_date,
    //         $house->contact_no,
    //         $house->advance,
    //         $house->rent,
    //         $house->detailed_address
    //     ];
    // }
    
    public function headings(): array
    {
        return[
            'Area', 'City', 'Type', 'Available From', 'Contact No', 'Advance', 'Rent', 'Address'
        ];
    }

    public function registerEvents(): array
    {
        return
        [
            AfterSheet::class => function(AfterSheet $event){
                $event->sheet->getStyle('A1:H1')->applyFromArray([
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
