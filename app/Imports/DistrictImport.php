<?php

namespace App\Imports;

use App\District;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;

class DistrictImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $district = District::create([
            'id' => $row[2],
            'name' => $row[1],
            'province_id' => $row[0],
            // 'created_at' => Carbon::now(),
            // 'updated_at' => Carbon::now(),
        ]);
    }
}
