<?php

namespace App\Repositories;

use App\District;
use App\Nationality;
use App\Province;
use App\Resident;
use App\Role;
use App\Ward;

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

    public function getPaginate10($cur_ward_id)
    {
        if ($cur_ward_id != 0) {
            return $this->_model->select('residents.*')
            ->join('roles', 'roles.id', '=', 'residents.role_id')
            ->where('roles.ward_id', $cur_ward_id)
            ->orderBy('id', 'asc')->paginate(10);
        } else {
            return $this->_model->orderBy('id', 'asc')->paginate(10);
            // return $this->_model->latest()->paginate(10);
        }
    }

    public function getFilter10($cur_ward_id)
    {
        $query = $this->_model::select('residents.*')->latest('users.created_at');

        if ($cur_ward_id != 0) {
            $query->join('roles', 'roles.id', '=', 'residents.role_id')->where('roles.ward_id', $cur_ward_id);
        }
        // Lấy dữ liệu công dân trong phạm vi quản lý

        if (!empty(request()->query('name'))) {
            $query->where([['users.name', 'like', '%' . request()->query('name') . '%']]);
        }

        if (!empty(request()->query('email'))) {
            $query->where([['users.email', 'like', '%' . request()->query('email') . '%']]);
        }

        // Lọc theo cấp độ
        if (request()->query('level') == 'Admin') {
            $query->join('roles', 'roles.id', '=', 'users.role_id')->where('roles.level', 1);
        } else if (request()->query('level') == 'Tram-truong') {
            $query->join('roles', 'roles.id', '=', 'users.role_id')->where('roles.level', 2);
        } else if (request()->query('level') == 'Nhan-vien-tram-y-te') {
            $query->join('roles', 'roles.id', '=', 'users.role_id')->where('roles.level', 3);
        } else if (request()->query('level') == 'Nhan-vien-uy-ban-phuong') {
            $query->join('roles', 'roles.id', '=', 'users.role_id')->where('roles.level', 4);
        } 

        // Lọc theo địa bàn quản lý quyền
        if (!empty(request()->query('ward'))) {
            $query->join('roles', 'roles.id', '=', 'users.role_id')->where('roles.ward_id', request()->query('ward'));

        } else if (!empty(request()->query('district'))) {
            $wards = $this->getActiveWards(request()->query('district'));
            // lấy các xã/phường có district_id là đầu vào và is_active = 1
            $query->join('roles', 'roles.id', '=', 'users.role_id')->whereIn('roles.ward_id', $this->getArrWardId($wards));
        } else if (!empty(request()->query('province'))) {
            $wards = Ward::select('wards.*')->join('districts', 'districts.id', '=', 'wards.district_id')->join('provinces', 'provinces.id', '=', 'districts.province_id')->where([['provinces.id', '=', request()->query('province')], ['wards.is_active', '=', 1], ['districts.is_active', '=', 1], ['provinces.is_active', '=', 1]])->get();

            // lấy các xã/phường có province_id là đầu vào và is_active = 1
            $query->join('roles', 'roles.id', '=', 'users.role_id')->whereIn('roles.ward_id', $this->getArrWardId($wards));
        }

        if (request()->query('status') == 'hien-thi') {
            $query->where('users.is_active', 1);
        } else if (request()->query('status') == 'an') {
            $query->where('users.is_active', 0);
        }
        
        if (request()->query('sort') == 'moi-nhat') {
            $query->orderBy('users.id', 'asc');
        } else if (request()->query('sort') == 'cu-nhat') {
            $query->orderBy('users.id', 'desc');
        } 

        return $query->paginate(10);
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
        
        $role_id = Role::where([['is_active', '=', 1], ['ward_id', '=', $cur_ward_id], ['level', '=', 5]])->get()->first();
        
        if (empty($role_id)) 
            return false;

        $resident = new Resident;
        $resident->name = $arr_data['name'];
        $resident->date_of_birth = $arr_data['date_of_birth'];
        $resident->phone = $arr_data['phone'];
        $resident->gender = $arr_data['gender'];
        $resident->identity_card = $arr_data['identity_card'];
        $resident->health_insurance_card = $arr_data['health_insurance_card'];
        $resident->nationality_id  = $arr_data['nationality_id'];
        $resident->ward_id  = $arr_data['ward_id'];
        $resident->address = $arr_data['address'];
        $resident->job = $arr_data['job'];
        $resident->work_place = $arr_data['work_place'];
        $resident->description = $arr_data['description'];
        $resident->status_id = $arr_data['status_id'];
        $resident->role_id = $role_id->id;

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
        $resident->health_insurance_card = $arr_data['health_insurance_card'];
        $resident->nationality_id  = $arr_data['nationality_id'];
        $resident->ward_id  = $arr_data['ward_id'];
        $resident->address = $arr_data['address'];
        $resident->job = $arr_data['job'];
        $resident->work_place = $arr_data['work_place'];
        $resident->description = $arr_data['description'];
        $resident->status_id = $arr_data['status_id'];

        if ($resident->save())
            return true;
        else
            return false;
    } 
}