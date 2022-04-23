<?php

namespace App\Imports;

use App\InjectionObject;
use App\Resident;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class ObjectImport implements ToModel
{
    private $arr_data;
    private $count_success = 0;
    private $count_failed = 0;
    private $data_failed = [];

    public function __construct ($data) {
        $this->arr_data = $data;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $check = false;
        
        $resident = Resident::where([['identity_card', '=', $row[0]]])->get();
        if (!empty($resident->first())) {
            $check_obj = InjectionObject::where([['resident_id', '=', $resident->first()->id], ['session_id', '=', $this->arr_data['session_id']]])->get();

            if (empty($check_obj->first())) {
                $object = new InjectionObject();
                $object->session_id = $this->arr_data['session_id'];
                $object->resident_id = $resident->first()->id;
                $object->status_id = 0;
                $object->save();
                $check = true;
                $this->count_success++;
            }
        }

        if (!$check) {
            $this->data_failed[] = $row[0];
            $this->count_failed++;
        }
    }

    public function getCountSuccess() {
        return $this->count_success;
    }

    public function getCountFailed() {
        return $this->count_failed;
    }
    
    public function getDataFailed() {
        return $this->data_failed;
    }
}
