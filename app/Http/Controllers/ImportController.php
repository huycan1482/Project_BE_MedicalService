<?php

namespace App\Http\Controllers;

use App\Imports\DistrictImport;
use App\Imports\NationalityImport;
use App\Imports\ObjectImport;
use App\Imports\ProvinceImport;
use App\Imports\WardImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function ImportProvince(Request $request)
    {
        $request->validate([
            'import_file' => 'required',
        ], [
            'import_file.required' => 'Yêu cầu không để trống',
        ]);
        $import = new ProvinceImport();
        Excel::import($import, request()->file('import_file'));
        return redirect()->route('admin.province.index');
    }

    public function ImportNationality(Request $request)
    {
        $request->validate([
            'import_file' => 'required',
        ], [
            'import_file.required' => 'Yêu cầu không để trống',
        ]);
        $import = new NationalityImport();
        Excel::import($import, request()->file('import_file'));
        return redirect()->route('admin.nationality.index');
    }

    public function ImportDistrict(Request $request)
    {
        $request->validate([
            'import_file' => 'required',
        ], [
            'import_file.required' => 'Yêu cầu không để trống',
        ]);
        $import = new DistrictImport();
        Excel::import($import, request()->file('import_file'));
        return redirect()->route('admin.district.index');
    }

    public function ImportWard(Request $request)
    {
        $request->validate([
            'import_file' => 'required',
        ], [
            'import_file.required' => 'Yêu cầu không để trống',
        ]);
        $import = new WardImport();
        Excel::import($import, request()->file('import_file'));
        return redirect()->route('admin.ward.index');
    }

    public function ImportObject (Request $request) {
        // $request->validate([
        //     'file' => $request->import_file,
        //     // 'extension' => strtolower($request->import_file->getClientOriginalExtension()),
        // ], [
        //     'file' => 'required',
        //     // 'extension' => 'required|in:doc,csv,xlsx,xls,docx,ppt,odt,ods,odp',
        // ], [
        //     'file.required' => 'Yêu cầu không để trống',
        // ]);

        $request->validate([
            'import_file' => 'required|mimes:xlsx, csv, xls',
        ], [
            'import_file.required' => 'Yêu cầu không để trống',
        ]);

        $arr_data = [
            'session_id' => $request->input('session_id'),
        ];

        $import = new ObjectImport($arr_data);

        try {
            Excel::import($import, request()->file('import_file'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'msg'=> 'Nhập dữ liệu không thành công',
            ]);
        }
        
        if ($import->getCountFailed() != 0) {
            return redirect()->back()->withErrors([
                'count_failed'=> $import->getCountFailed(),
                'count_success'=> $import->getCountSuccess(),
                'data_failed' => $import->getDataFailed(),
            ]);
        }

        return redirect()->back();
    }
}
