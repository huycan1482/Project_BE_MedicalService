<?php

namespace App\Repositories;

use App\District;
use App\Province;
use App\Role;
use App\User;
use App\Ward;
use Illuminate\Support\Facades\Hash;

class UserRepository extends EloquentRepository
{
     /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\User::class;
    }

    public function getUsersWithTrashed () {
        $query = $this->_model::latest('users.created_at');

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

    public function getPaginate10()
    {
        // return $this->_model->latest()->paginate(10);
        return $this->_model->orderBy('id', 'asc')->paginate(10);
    }

    public function getFilter10()
    {
        $query = $this->_model::latest('users.created_at');

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

    public function getActiveRoles ($ward_id) {
        if ($ward_id != 0) {
            return Role::where([['is_active', '=', 1], ['ward_id', '=', $ward_id]])->get();
        } else {
            return Role::where('is_active', 1)->get();
        }
    }

    public function createUser ($arr_data) {
        // dd($arr_data);
        $user = new User();
        $user->name = $arr_data['name'];
        $user->gender = $arr_data['gender'];
        $user->date_of_birth = $arr_data['date_of_birth'];
        $user->phone = $arr_data['phone'];
        $user->identity_card = $arr_data['identity_card'];
        $user->address = $arr_data['address'];
        $user->description = $arr_data['description'];
        $user->is_active = $arr_data['is_active'];
        $user->email = $arr_data['email'];
        $user->password = Hash::make($arr_data['password']);
        $user->ward_id = $arr_data['ward_id'];
        $user->role_id = $arr_data['role_id'];

        if ($user->save())
            return true;
        else
            return false;
    }

    public function updateUser($user_id, $arr_data) {
        $user = User::find($user_id);
        $user->name = $arr_data['name'];
        $user->gender = $arr_data['gender'];
        $user->date_of_birth = $arr_data['date_of_birth'];
        $user->phone = $arr_data['phone'];
        $user->identity_card = $arr_data['identity_card'];
        $user->address = $arr_data['address'];
        $user->description = $arr_data['description'];
        $user->is_active = $arr_data['is_active'];
        $user->email = $arr_data['email'];
        
        if (!empty($arr_data['password'])) {
            $user->password = Hash::make($arr_data['password']);
        }

        $user->ward_id = $arr_data['ward_id'];
        $user->role_id = $arr_data['role_id'];

        if ($user->save())
            return true;
        else
            return false;
    }

    public function getArrWardId($wards) {
        
        $wards_id = [];

        foreach ($wards as $ward) {
            $wards_id[] = $ward->id;
        }

        return $wards_id;
    }
}