<?php

namespace App\Repositories;

use App\District;
use App\Province;
use App\Role;
use App\Ward;

class RoleRepository extends EloquentRepository
{
     /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Role::class;
    }

    public function getRoleWithTrashed() {
        $query = $this->_model->select()->onlyTrashed();

        // Tìm kiếm theo tên
        if (!empty(request()->query('name'))) {
            $query->where([['name', 'like', '%' . request()->query('name') . '%']]);
        }

        // Lọc them trạng thái
        if (request()->query('status') == 'hien-thi') {
            $query->where('is_active', 1);
        } else if (request()->query('status') == 'an') {
            $query->where('is_active', 0);
        }

        // Lọc theo cấp độ
        if (request()->query('level') == 'Admin') {
            $query->where('level', 1);
        } else if (request()->query('level') == 'Tram-truong') {
            $query->where('level', 2);
        } else if (request()->query('level') == 'Nhan-vien-tram-y-te') {
            $query->where('level', 3);
        } else if (request()->query('level') == 'Nhan-vien-uy-ban-phuong') {
            $query->where('level', 4);
        } else if (request()->query('level') == 'Cong-dan-sinh-song-trong-khu-vuc') {
            $query->where('level', 5);
        }

        // Lọc theo địa bàn quản lý
        if (!empty(request()->query('ward'))) {
            $query->where('ward_id', request()->query('ward_id'));
        } else if (!empty(request()->query('district'))) {
            $wards = $this->getActiveWards(request()->query('district'));
            // lấy các xã/phường có district_id là đầu vào và is_active = 1
            $query->whereIn('ward_id', $this->getArrWardId($wards));
        } else if (!empty(request()->query('province'))) {
            $wards = Ward::select('wards.*')->join('districts', 'districts.id', '=', 'wards.district_id')->join('provinces', 'provinces.id', '=', 'districts.province_id')->where([['provinces.id', '=', request()->query('province')], ['wards.is_active', '=', 1], ['districts.is_active', '=', 1], ['provinces.is_active', '=', 1]])->get();
            // lấy các xã/phường có province_id là đầu vào và is_active = 1
            $query->whereIn('ward_id', $this->getArrWardId($wards));
        }

        // Sắp xếp theo ngày thêm
        if (request()->query('sort') == 'moi-nhat') {
            $query->orderBy('id', 'asc');
        } else if (request()->query('sort') == 'cu-nhat') {
            $query->orderBy('id', 'desc');
        }
        return $query->paginate(10);
    }

    public function getPaginate10()
    {
        // return $this->_model->latest()->paginate(10);
        return $this->_model->orderBy('id', 'asc')->paginate(10);
    }

    public function getFilter10()
    {
        $query = $this->_model->select();

        // Tìm kiếm theo tên
        if (!empty(request()->query('name'))) {
            $query->where([['name', 'like', '%' . request()->query('name') . '%']]);
        }

        // Lọc them trạng thái
        if (request()->query('status') == 'hien-thi') {
            $query->where('is_active', 1);
        } else if (request()->query('status') == 'an') {
            $query->where('is_active', 0);
        }

        // Lọc theo cấp độ
        if (request()->query('level') == 'Admin') {
            $query->where('level', 1);
        } else if (request()->query('level') == 'Tram-truong') {
            $query->where('level', 2);
        } else if (request()->query('level') == 'Nhan-vien-tram-y-te') {
            $query->where('level', 3);
        } else if (request()->query('level') == 'Nhan-vien-uy-ban-phuong') {
            $query->where('level', 4);
        } else if (request()->query('level') == 'Cong-dan-sinh-song-trong-khu-vuc') {
            $query->where('level', 5);
        }

        // Lọc theo địa bàn quản lý
        if (!empty(request()->query('ward'))) {
            $query->where('ward_id', request()->query('ward_id'));
        } else if (!empty(request()->query('district'))) {
            $wards = $this->getActiveWards(request()->query('district'));
            // lấy các xã/phường có district_id là đầu vào và is_active = 1
            $query->whereIn('ward_id', $this->getArrWardId($wards));
        } else if (!empty(request()->query('province'))) {
            $wards = Ward::select('wards.*')->join('districts', 'districts.id', '=', 'wards.district_id')->join('provinces', 'provinces.id', '=', 'districts.province_id')->where([['provinces.id', '=', request()->query('province')], ['wards.is_active', '=', 1], ['districts.is_active', '=', 1], ['provinces.is_active', '=', 1]])->get();
            // lấy các xã/phường có province_id là đầu vào và is_active = 1
            $query->whereIn('ward_id', $this->getArrWardId($wards));
        }

        // Sắp xếp theo ngày thêm
        if (request()->query('sort') == 'moi-nhat') {
            $query->orderBy('id', 'asc');
        } else if (request()->query('sort') == 'cu-nhat') {
            $query->orderBy('id', 'desc');
        }
        return $query->paginate(10);
    }

    public function getActiveWards ($district_id) {
        if ($district_id !=0 ) {
            return Ward::where([['is_active', '=', 1], ['district_id', '=', $district_id]])->get();
        } else { 
            return Ward::where('is_active', 1)->get();
        }
    }

    public function getActiveDistricts ($province_id) {
        if ($province_id !=0 ) {
            return District::where([['is_active', '=', 1], ['province_id', '=', $province_id]])->get();
        } else { 
            return District::where('is_active', 1)->get();
        }
    }

    public function getActiveProvinces () {
        return Province::where('is_active', 1)->get();
    }

    public function getActiveRole ($ward_id) {
        if ($ward_id !=0 ) {
            return Role::where([['is_active', '=', 1], ['ward_id', '=', $ward_id]])->get();
        } else { 
            return Role::where('is_active', 1)->get();
        }
    }

    public function getArrWardId($wards) {
        $wards_id = [];

        foreach ($wards as $ward) {
            $wards_id[] = $ward->id;
        }

        return $wards_id;
    }
}