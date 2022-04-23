<?php

namespace App\Repositories;

use App\Disease;
use App\District;
use App\Ethnic;
use App\Injection;
use App\Nationality;
use App\Province;
use App\Resident;
use App\Role;
use App\Ward;
use Illuminate\Support\Facades\DB;

class ResidentRepository extends EloquentRepository
{
     /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Resident::class;
    }

    public function getResidentsWithTrashed () {
        $query = $this->_model::onlyTrashed()->select('residents.*')->latest('residents.created_at');

        if (!empty(request()->query('name'))) {
            $query->where([['residents.name', 'like', '%' . request()->query('name') . '%']]);
        }

        if (!empty(request()->query('phone'))) {
            $query->where([['residents.phone', 'like', '%' . request()->query('phone') . '%']]);
        }

        if (!empty(request()->query('email'))) {
            $query->where([['residents.email', 'like', '%' . request()->query('email') . '%']]);
        }

        if (!empty(request()->query('identity'))) {
            $query->where([['residents.identity_card', 'like', '%' . request()->query('identity') . '%']]);
        }

        // Lọc theo địa bàn quản lý
        if (!empty(request()->query('ward'))) {
            $query->where('residents.ward_id', request()->query('ward'));

        } else if (!empty(request()->query('district'))) {
            $wards = $this->getActiveWards(request()->query('district'));
            // lấy các xã/phường có district_id là đầu vào và is_active = 1
            $query->whereIn('residents.ward_id', $this->getArrWardId($wards));
        } else if (!empty(request()->query('province'))) {
            $wards = Ward::select('wards.*')->join('districts', 'districts.id', '=', 'wards.district_id')->join('provinces', 'provinces.id', '=', 'districts.province_id')->where([['provinces.id', '=', request()->query('province')], ['wards.is_active', '=', 1], ['districts.is_active', '=', 1], ['provinces.is_active', '=', 1]])->get();

            // lấy các xã/phường có province_id là đầu vào và is_active = 1
            $query->whereIn('residents.ward_id', $this->getArrWardId($wards));
        }

        if (request()->query('status') == 'hien-thi') {
            $query->where('residents.is_active', 1);
        } else if (request()->query('status') == 'an') {
            $query->where('residents.is_active', 0);
        }
        
        if (request()->query('sort') == 'moi-nhat') {
            $query->orderBy('residents.id', 'asc');
        } else if (request()->query('sort') == 'cu-nhat') {
            $query->orderBy('residents.id', 'desc');
        } 

        return $query->paginate(10);
    }

    public function getPaginate10($cur_ward_id)
    {
        if ($cur_ward_id != 0) {
            return $this->_model->select('residents.*')
            ->where('residents.ward_id', $cur_ward_id)
            ->orderBy('id', 'asc')->paginate(10);
        } else {
            return $this->_model->orderBy('id', 'asc')->paginate(10);
            // return $this->_model->latest()->paginate(10);
        }
    }

    public function getFilter10($cur_ward_id)
    {
        $query = $this->_model::select('residents.*')->latest('residents.created_at');

        if ($cur_ward_id != 0) {
            $query->where('residents.ward_id', $cur_ward_id);
        }
        // Lấy dữ liệu công dân trong phạm vi quản lý

        if (!empty(request()->query('name'))) {
            $query->where([['residents.name', 'like', '%' . request()->query('name') . '%']]);
        }

        if (!empty(request()->query('phone'))) {
            $query->where([['residents.phone', 'like', '%' . request()->query('phone') . '%']]);
        }

        if (!empty(request()->query('email'))) {
            $query->where([['residents.email', 'like', '%' . request()->query('email') . '%']]);
        }

        if (!empty(request()->query('identity'))) {
            $query->where([['residents.identity_card', 'like', '%' . request()->query('identity') . '%']]);
        }

        // Lọc theo địa bàn quản lý
        if (!empty(request()->query('ward'))) {
            $query->where('residents.ward_id', request()->query('ward'));

        } else if (!empty(request()->query('district'))) {
            $wards = $this->getActiveWards(request()->query('district'));
            // lấy các xã/phường có district_id là đầu vào và is_active = 1
            $query->whereIn('residents.ward_id', $this->getArrWardId($wards));
        } else if (!empty(request()->query('province'))) {
            $wards = Ward::select('wards.*')->join('districts', 'districts.id', '=', 'wards.district_id')->join('provinces', 'provinces.id', '=', 'districts.province_id')->where([['provinces.id', '=', request()->query('province')], ['wards.is_active', '=', 1], ['districts.is_active', '=', 1], ['provinces.is_active', '=', 1]])->get();

            // lấy các xã/phường có province_id là đầu vào và is_active = 1
            $query->whereIn('residents.ward_id', $this->getArrWardId($wards));
        }

        if (request()->query('status') == 'hien-thi') {
            $query->where('residents.is_active', 1);
        } else if (request()->query('status') == 'an') {
            $query->where('residents.is_active', 0);
        }
        
        if (request()->query('sort') == 'moi-nhat') {
            $query->orderBy('residents.id', 'asc');
        } else if (request()->query('sort') == 'cu-nhat') {
            $query->orderBy('residents.id', 'desc');
        } 

        return $query->paginate(10);
    }

    public function getActiveEthnics () {
        return Ethnic::where('is_active', 1)->latest()->get();
    }

    public function getActiveProvinces () {
        return Province::where('is_active', 1)->get();
    }

    public function getActiveDistricts ($province_id) {
        if ($province_id != 0) {
            return District::where([['is_active', '=', 1], ['province_id', '=', $province_id]])->get();
        } else {
            return District::where('is_active', 1)->get();
        }
    }

    public function getActiveWards ($district_id) {
        if ($district_id != 0) {
            return Ward::where([['is_active', '=', 1], ['district_id', '=', $district_id]])->get();
        } else {
            return Ward::where('is_active', 1)->get();
        }
    }

    public function getArrWardId($wards) {
        
        $wards_id = [];

        foreach ($wards as $ward) {
            $wards_id[] = $ward->id;
        }

        return $wards_id;
    }

    public function getActiveNationality() {
        return Nationality::where('is_active', 1)->get();
    }

    public function createResident ($arr_data, $cur_ward_id) {
        
        // $role_id = Role::where([['is_active', '=', 1], ['ward_id', '=', $cur_ward_id], ['level', '=', 5]])->get()->first();
        
        // if (empty($role_id)) 
        //     return false;

        $resident = new Resident;
        $resident->name = $arr_data['name'];
        $resident->date_of_birth = $arr_data['date_of_birth'];
        $resident->phone = $arr_data['phone'];
        $resident->gender = $arr_data['gender'];
        $resident->identity_card = $arr_data['identity_card'];
        $resident->ethnic_id = $arr_data['ethnic_id'];
        $resident->email = $arr_data['email'];
        $resident->health_insurance_card = $arr_data['health_insurance_card'];
        $resident->nationality_id  = $arr_data['nationality_id'];
        $resident->ward_id  = $arr_data['ward_id'];
        $resident->address = $arr_data['address'];
        $resident->job = $arr_data['job'];
        $resident->work_place = $arr_data['work_place'];
        $resident->description = $arr_data['description'];
        $resident->is_active = $arr_data['is_active'];
        // $resident->role_id = $role_id->id;

        if ($resident->save())
            return true;
        else
            return false;
    }

    public function updateResident ($resident_id, $arr_data) {
        $resident = Resident::find($resident_id);
        $resident->name = $arr_data['name'];
        $resident->date_of_birth = $arr_data['date_of_birth'];
        $resident->phone = $arr_data['phone'];
        $resident->gender = $arr_data['gender'];
        $resident->identity_card = $arr_data['identity_card'];
        $resident->ethnic_id = $arr_data['ethnic_id'];
        $resident->email = $arr_data['email'];
        $resident->health_insurance_card = $arr_data['health_insurance_card'];
        $resident->nationality_id  = $arr_data['nationality_id'];
        $resident->ward_id  = $arr_data['ward_id'];
        $resident->address = $arr_data['address'];
        $resident->job = $arr_data['job'];
        $resident->work_place = $arr_data['work_place'];
        $resident->description = $arr_data['description'];
        $resident->is_active = $arr_data['is_active'];
        if ($resident->save())
            return true;
        else
            return false;
    } 

    public function getActiveDiseases () {
        return Disease::where('is_active', 1)->get();
    }    

    public function getListInjection ($resident_id, $disease_id) {
        $data = Resident::select('residents.name', 'injections.dose', 'vaccines.id as vaccine_id', 'vaccines.name as vaccine_name', 'packs.name as pack_name',  DB::raw('group_concat(diseases.name) as disease_name'), 'injections.date', 'injections.id as injection_id')
        ->join('injections', 'residents.id', '=', 'injections.resident_id')
        ->join('packs', 'packs.id', '=', 'injections.pack_id')
        ->join('vaccines', 'vaccines.id', '=', 'packs.vaccine_id')
        ->leftJoin('vaccine_disease', 'vaccine_disease.vaccine_id', '=', 'vaccines.id')
        ->leftJoin('diseases', 'diseases.id', '=', 'vaccine_disease.disease_id');

        if (!empty($disease_id)) {
            $data->where('diseases.id', $disease_id);
        } 

        $data->where('residents.id', $resident_id)
        ->orderBy('date', 'asc')
        ->groupBy('vaccines.id');

        return $data->get();
    }

    // public function getArrVaccine ($data) {
    //     // dd($data);
    //     foreach ($data as $key => $item) {
    //         $arr_diseases = Disease::select('diseases.id')
    //         ->join('vaccine_disease', 'vaccine_disease.disease_id', '=', 'diseases.id')
    //         ->where('vaccine_disease.vaccine_id', 3)
    //         ->groupBy('diseases.id')->get()->toArray();
    //         dd($arr_diseases);
    //     }

    //     dd($arr_diseases);
    // }

    // public function getListDisease ($resident_id) {
    //     $this->getArrVaccine($this->getListInjection($resident_id));
    // }
}