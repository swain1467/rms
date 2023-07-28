<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;

use App\Models\House;

class HouseDetailsImport implements 
ToModel,
WithHeadingRow
{
    use Importable;
    public function model (array $row){
        return new House([
            'area_id' => $row['area'],
            'city_id' => $row['city'],
            'type_id' => $row['type'],
            'from_date' => $row['available_from'],
            'contact_no' => $row['contact_no'],
            'advance' => $row['advance'],
            'rent' => $row['rent'],
            'detailed_address' => $row['address'],
            'created_by' => session('id'),
            'updated_by' => session('id'),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            'status' => 1
        ]) ;
    }
}
