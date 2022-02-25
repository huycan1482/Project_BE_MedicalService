<?php

namespace App\Imports;

use App\Nationality;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;

class NationalityImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $nationality = Nationality::create([
            'id' => $row[0],
            'name' => $row[1],
            'abbreviation' => $row[2],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
