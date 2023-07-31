<?php

namespace App\Imports;

use Illuminate\Support\Collection;
// Traits
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
// Interface
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\ToModel;

use App\Models\House;
use App\Models\City;
use App\Models\Area;

class HouseDetailsImport implements 
ToModel,
WithHeadingRow
// SkipsOnError
// WithValidation
{
    use Importable, SkipsErrors;

    private $city;
    private $type;
    public function __construct($cities, $types)
    {
        $this->city = $cities;
        $this->type = $types;
    }
    public function model (array $row){
        // Validate Type
        $type_id = null;
        if (in_array($row['type'], $this->type))
        {
            $type_id = array_search($row['type'],$this->type);
        }
        else
        {
            die;
        }

        // Validate City
        $city_id = null;
        if (in_array($row['city'], $this->city))
        {
            $city_id = array_search($row['city'],$this->city);
        }
        else
        {
            die;
        }
        // Validate Area
        $area_id = null;
        $area = Area::with('city:city_name,id')
        ->select("id", "area_name", "city_id")
        ->where('status', 1)
        ->where('city_id', $city_id)
        ->where('area_name', $row['area'])
        ->orderBy('area_name', 'ASC')
        ->get()->toArray();

        if(COUNT($area)>0){
            $area_id = $area[0]['id'];
        }else{
            die;
        }
        return new House([
            'area_id' => $area_id,
            'city_id' => $city_id,
            'type_id' => $type_id,
            'from_date' => $row['available_from'],
            'contact_no' => $row['contact_no'],
            'advance' => $row['advance'],
            'rent' => $row['rent'],
            'detailed_address' => $row['address'],
            'image' => 'NoImage',
            'created_by' => session('id'),
            'updated_by' => session('id'),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            'status' => 1
        ]) ;
    }

}
