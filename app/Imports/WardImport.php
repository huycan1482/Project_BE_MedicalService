<?php

namespace App\Imports;

use App\Ward;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;

class WardImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (!empty($row[2])) {
            $ward = Ward::create([
                'id' => $row[2],
                'name' => $row[1],
                'district_id' => $row[0],
                'is_active' => 1,
            ]);
        }
    }
}
