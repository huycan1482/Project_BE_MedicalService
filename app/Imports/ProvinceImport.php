<?php

namespace App\Imports;

use App\Province;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;

class ProvinceImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $province = Province::create([
            'id' => $row[1],
            'name' => $row[0],
            'code' => (1000 + $row[1]),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
