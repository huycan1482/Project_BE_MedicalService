@extends('admin.layouts.main')

@section('header_title')
<title>Medical Services | Users</title>
@endsection

@section('content')

<section class="content-header">
    <h1>
        Sửa - Người dùng
        <small>
            <a href="{{ route('admin.resident.index') }}"><span class="label label-success">Danh sách</span></a>
        </small>
    </h1>
</section>

<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
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
                                <label class="" for="name">Tên Công dân <span class="required-dot">**</span></label>
                                <div>
                                    <input id="name" name="name" type="text" class="form-control" placeholder="Tên Công dân" value="{{ $resident->name }}">
                                </div>
                            </div>
                            <div class="form-group d-flex col-lg-3" id="form-gender">
                                <label class="" for="gender">Giới tính <span class="required-dot">**</span></label>
                                <div>
                                    <select class="form-control" name="gender" id="gender">
                                        <option value="" selected disabled>--Chọn--</option>
                                        <option value="1" {{ $resident->gender == 1 ? 'selected' : '' }}>Nam</option>
                                        <option value="0" {{ $resident->gender == 0 ? 'selected' : '' }}>Nữ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group d-flex col-lg-4" id="form-date_of_birth">
                                <label class="" for="date_of_birth">Ngày tháng năm sinh <span class="required-dot">**</span></label>
                                <div>
                                    <input id="date_of_birth" name="date_of_birth" type="date" class="form-control" placeholder="Ngày tháng năm sinh" value="{{ $resident->date_of_birth }}">
                                </div>
                            </div>
                            <div class="form-group d-flex col-lg-3" id="form-phone">
                                <label class="" for="phone">Số điện thoại <span class="required-dot">**</span></label>
                                <div>
                                    <input id="phone" name="phone" type="text" class="form-control" placeholder="Số điện thoại" value="{{ $resident->phone }}">
                                </div>
                            </div>
                            <div class="form-group col-lg-3" id="form-nationality_id">
                                <label>Quốc gia</label><span class="required-dot">**</span>
                                <div>
                                    <select class="select2 form-control" style="width: 100%;" name="nationality_id" id="nationality_id">
                                        <option value="">-- Chọn --</option>
                                        @foreach ($nationalities as $nationaly)
                                        <option value="{{ $nationaly->id }}" {{ $resident->belongsToNationality->id == $nationaly->id ? 'selected' : ''}}>{{ $nationaly->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group d-flex col-lg-3" id="form-identity_card">
                                <label class="" for="identity_card">CCCD/Mã định danh/Hộ chiếu <span class="required-dot">**</span></label>
                                <div>
                                    <input id="identity_card" name="identity_card" type="text" class="form-control" placeholder="CCCD/Mã định danh/Hộ chiếu" value=" {{ $resident->identity_card }}">
                                </div>
                            </div>
                            <div class="form-group d-flex col-lg-3" id="form-ethnic_id">
                                <label class="" for="ethnic_id">Dân tộc<span class="required-dot">**</span></label>
                                <div>
                                    <select class="select2 form-control" style="width: 100%;" name="ethnic_id" id="ethnic_id">
                                        <option value="">-- Chọn --</option>
                                        @foreach ($ethnics as $ethnic)
                                        <option value="{{ $ethnic->id }}" {{ $resident->ethnic_id == $ethnic->id ? 'selected' : '' }}>{{ $ethnic->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group d-flex col-lg-4" id="form-email">
                                <label class="" for="email">Email</label>
                                <div>
                                    <input id="email" name="email" type="text" class="form-control" placeholder="Email" value="{{ $resident->email }}">
                                </div>
                            </div>
                            <div class="form-group d-flex col-lg-4" id="form-health_insurance_card">
                                <label class="" for="health_insurance_card">Thẻ BHYT</label>
                                <div>
                                    <input id="health_insurance_card" name="health_insurance_card" type="text" class="form-control" placeholder="Thẻ BHYT" value="{{ $resident->health_insurance_card }}">
                                </div>
                            </div>
                            <div class="form-group d-flex col-lg-4" id="form-job">
                                <label class="" for="job">Nghề nghiệp </label>
                                <div>
                                    <input id="job" name="job" type="text" class="form-control" placeholder="Nghề nghiệp" value="{{ $resident->job }}">
                                </div>
                            </div>
                            <div class="form-group d-flex col-lg-12" id="form-work_place">
                                <label class="" for="work_place">Địa chỉ làm việc </label>
                                <div>
                                    <input id="work_place" name="work_place" type="text" class="form-control" placeholder="Địa chỉ làm việc" value="{{ $resident->work_place }}">
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
                                        <option value="{{ $province->id }}" {{ $resident->belongsToWard->belongsToDistrict->belongsToProvince->id == $province->id ? ' selected' : '' }}>{{ $province->name }}</option>
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
                                        <option value="{{ $district->id }}" {{ $resident->belongsToWard->belongsToDistrict->id == $district->id ? ' selected' : '' }} >{{ $district->name }}</option>
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
                                        <option value="{{ $ward->id }}" {{ $resident->belongsToWard->id == $ward->id ? ' selected' : '' }} >{{ $ward->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group d-flex col-lg-12" id="form-address">
                                <label class="" for="address">Địa chỉ chi tiết<span class="required-dot">**</span></label>
                                <div>
                                    <input id="address" name="address" type="text" class="form-control" placeholder="Địa chỉ" value="{{ $resident->address }}">
                                </div>
                            </div>
                            <div class="form-group d-flex col-lg-12" style="flex-direction: column" id="form-description">
                                <label for="description">Ghi chú</label>
                                <div style="width: 100%;">
                                    <textarea id="description" name="description" class="form-group">{{ $resident->description }}</textarea>
                                </div>
                            </div>
                            <div class="checkbox form-group col-lg-12" id="form-is_active">         
                                <label>
                                    <input type="checkbox" name="is_active" value="1" {{$resident->is_active == 1 ? 'checked' : '' }}>Trạng thái kích hoạt
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <a href="javascript:void(0)" class="btn btn-primary edit-resident" data-id="{{ $resident->id }}">Sửa</a>
                        <button type="reset" class="btn btn-danger">Tải lại</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
        <!--/.col (right) -->
        
    </div>
    <!-- /.row -->
</section>
@endsection

@section('js')
<script src="/AdminLTE/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="/myAssets/js/myJS.js"></script>
<script src="/myAssets/js/notice.js"></script>
<script src="/myAssets/js/resident/create.js"></script>
@endsection