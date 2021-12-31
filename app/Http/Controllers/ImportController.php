<?php

namespace App\Http\Controllers;

use App\Imports\ProvinceImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function importProvince(Request $request)
    {
        $import = new ProvinceImport();
        Excel::import($import, request()->file('import_file'));
    }
}
