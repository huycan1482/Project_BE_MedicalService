<?php

namespace App\Http\Controllers;

use App\Imports\DistrictImport;
use App\Imports\NationalityImport;
use App\Imports\ProvinceImport;
use App\Imports\WardImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function ImportProvince(Request $request)
    {
        $import = new ProvinceImport();
        Excel::import($import, request()->file('import_file'));
        return redirect()->route('admin.province.index');
    }

    public function ImportNationality(Request $request)
    {
        $import = new NationalityImport();
        Excel::import($import, request()->file('import_file'));
        return redirect()->route('admin.nationality.index');
    }

    public function ImportDistrict(Request $request)
    {
        $import = new DistrictImport();
        Excel::import($import, request()->file('import_file'));
        return redirect()->route('admin.district.index');
    }

    public function ImportWard(Request $request)
    {
        $import = new WardImport();
        Excel::import($import, request()->file('import_file'));
        return redirect()->route('admin.ward.index');
    }
}
