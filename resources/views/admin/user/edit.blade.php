@extends('admin.layouts.main')

@section('header_title')
<title>Medical Services | Users</title>
@endsection

@section('content')

<section class="content-header">
    <h1>
        Sửa - Người dùng
        <small>
            <a href="{{ route('admin.user.index') }}"><span class="label label-success">Danh sách</span></a>
        </small>
    </h1>
</section>

<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-8">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin chung Người dùng</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="">

                    <div class="box-body">
                        <div class="row">
                            <div class="form-group d-flex col-lg-5" id="form-name">
                                <label class="" for="name">Tên Người dùng <span class="required-dot">**</span></label>
                                <div>
                                    <input id="name" name="name" type="text" class="form-control" placeholder="Tên Người dùng" value="{{ $user->name }}">
                                </div>
                            </div>
                            <div class="form-group d-flex col-lg-3" id="form-gender">
                                <label class="" for="gender">Giới tính <span class="required-dot">**</span></label>
                                <div>
                                    <select class="form-control" name="gender" id="gender">
                                        <option value="" disabled>--Chọn--</option>
                                        <option value="1" {{ $user->gender == 1 ? 'selected' : ''}}>Nam</option>
                                        <option value="0" {{ $user->gender == 0 ? 'selected' : ''}}>Nữ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group d-flex col-lg-4" id="form-date_of_birth">
                                <label class="" for="date_of_birth">Ngày tháng năm sinh <span class="required-dot">**</span></label>
                                <div>
                                    <input id="date_of_birth" name="date_of_birth" type="date" class="form-control" placeholder="Ngày tháng năm sinh" value="{{ $user->date_of_birth }}">
                                </div>
                            </div>
                            <div class="form-group d-flex col-lg-6" id="form-phone">
                                <label class="" for="phone">Số điện thoại <span class="required-dot">**</span></label>
                                <div>
                                    <input id="phone" name="phone" type="text" class="form-control" placeholder="Số điện thoại" value="{{ $user->phone }}">
                                </div>
                            </div>
                            <div class="form-group d-flex col-lg-6" id="form-identity_card">
                                <label class="" for="identity_card">CCCD/Mã định danh <span class="required-dot">**</span></label>
                                <div>
                                    <input id="identity_card" name="identity_card" type="text" class="form-control" placeholder="CCCD/Mã định danh" value="{{ $user->identity_card }}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label style="color: #2980b9">Hộ khẩu thường trú<span class="required-dot">**</span></label>
                            </div>
                            <div class="form-group col-lg-4" id="form-province">
                                <label>Tỉnh/Thành phố</label>
                                <div>
                                    <select class="select2 form-control" style="width: 100%;" name="province_id" id="province_id">
                                        <option value="">-- Chọn --</option>
                                        @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}" {{ $user->belongsToWard->belongsToDistrict->belongsToProvince->id == $province->id ? ' selected="selected"' : '' }}>{{ $province->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
        
                            <div class="form-group col-lg-4" id="form-district_id">
                                <label>Quận/Huyện</label>
                                <div>
                                    <select class="select2 form-control" style="width: 100%;" name="district_id" id="district_id">
                                        <option value="">-- Chọn --</option>
                                        @foreach ($districts as $district)
                                        <option value="{{ $district->id }}" {{ $user->belongsToWard->belongsToDistrict->id == $district->id ? ' selected="selected"' : '' }}>{{ $district->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
        
                            <div class="form-group col-lg-4" id="form-ward_id">
                                <label>Xã/Phường <span class="required-dot">**</span></label>
                                <div>
                                    <select class="select2 form-control" style="width: 100%;" name="ward_id" id="ward_id">
                                        <option value="">-- Chọn --</option>
                                        @foreach ($wards as $ward)
                                        <option value="{{ $ward->id }}" {{ $user->ward_id == $ward->id ? ' selected="selected"' : '' }}>{{ $ward->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group d-flex col-lg-12" id="form-address">
                                <label class="" for="address">Địa chỉ chi tiết<span class="required-dot">**</span></label>
                                <div>
                                    <input id="address" name="address" type="text" class="form-control" placeholder="Địa chỉ" value="{{ $user->address }}">
                                </div>
                            </div>
                            <div class="form-group d-flex col-lg-12" style="flex-direction: column" id="form-description">
                                <label for="description">Mô tả</label>
                                <div style="width: 100%;">
                                    <textarea id="description" name="description" class="form-group">{{ $user->description }}</textarea>
                                </div>
                            </div>
                            <div class="checkbox form-group col-lg-12" id="form-is_active">         
                                <label>
                                    <input type="checkbox" name="is_active" value="1" {{ $user->is_active == 1 ? 'checked' : '' }}>Trạng thái kích hoạt
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <a href="javascript:void(0)" class="btn btn-primary edit-user" data-id="{{ $user->id }}">Sửa</a>
                        <button type="reset" class="btn btn-danger">Tải lại</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
        <!--/.col (right) -->

        <div class="col-md-4">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin Tài khoản</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="">

                    <div class="box-body">
                        <div class="form-group d-flex" id="form-email">
                            <label class="" for="email">Email <span class="required-dot">**</span></label>
                            <div>
                                <input id="email" name="email" type="email" class="form-control" placeholder="Eamil đăng nhập" value="{{ $user->email }}">
                            </div>
                        </div>
                        <div class="form-group d-flex" id="form-password">
                            <label class="" for="password">Mật khẩu mới</label>
                            <div>
                                <input id="password" name="password" type="password" class="form-control" placeholder="Mật khẩu">
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </form>
            </div>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin Quyền</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="">
                    <div class="box-body">
                        <div class="form-group" id="form-province2">
                            <label>Tỉnh/Thành phố quản lý</label>
                            <div>
                                <select class="select2 form-control" style="width: 100%;" name="province_id2" id="province_id2">
                                    <option value="">-- Chọn --</option>
                                    @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}" {{ $user->belongsToWard->belongsToDistrict->belongsToProvince->id == $province->id ? 'selected' : '' }}>{{ $province->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
    
                        <div class="form-group" id="form-district_id2">
                            <label>Quận/Huyện quản lý</label>
                            <div>
                                <select class="select2 form-control" style="width: 100%;" name="district_id2" id="district_id2">
                                    <option value="">-- Chọn --</option>
                                    @foreach ($districts as $district)
                                    <option value="{{ $district->id }}" {{ $user->belongsToWard->belongsToDistrict->id == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
    
                        <div class="form-group" id="form-ward_id2">
                            <label>Xã/Phường quản lý <span class="required-dot">**</span></label>
                            <div>
                                <select class="select2 form-control" style="width: 100%;" name="ward_id2" id="ward_id2">
                                    <option value="">-- Chọn --</option>
                                    @foreach ($wards as $ward)
                                    <option value="{{ $ward->id }}" {{ $user->belongsToWard->id == $ward->id ? 'selected' : '' }}>{{ $ward->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group" id="form-role_id">
                            <label>Quyền <span class="required-dot">**</span></label>
                            <div>
                                <select class="select2 form-control" style="width: 100%;" name="role_id" id="role_id">
                                    <option value="">-- Chọn --</option>
                                    @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>  
            <!-- /.box -->
        </div>
        
    </div>
    <!-- /.row -->
</section>
@endsection

@section('js')
<script src="/AdminLTE/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="/myAssets/js/myJS.js"></script>
<script src="/myAssets/js/notice.js"></script>
<script src="/myAssets/js/user/create.js"></script>
@endsection