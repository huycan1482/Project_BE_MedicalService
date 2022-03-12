@extends('admin.layouts.main')

@section('header_title')
<title>Medical Services | Roles</title>
@endsection

@section('content')

<section class="content-header">
    <h1>
        Sửa - Quyền
        <small>
            <a href="{{ route('admin.role.index') }}"><span class="label label-success">Danh sách</span></a>
        </small>
    </h1>
</section>

<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-7">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin chung Quyền</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="">
                    <div class="box-body">
                        <div class="form-group d-flex" id="form-name">
                            <label class="" for="name">Tên Quyền</label>
                            <div>
                                <input id="name" name="name" type="text" class="form-control" placeholder="Tên Quyền" value="{{ $role->name }}">
                            </div>
                        </div>
                        <div class="form-group d-flex" id="form-level">
                            <label class="" for="level">Cấp độ</label>
                            <div>
                                <select class="form-control" name="level" id="level">
                                    <option value="">-- Chọn --</option>
                                    <option value="1" {{ $role->level == 1 ? 'selected' : '' }}>Admin</option>
                                    <option value="2" {{ $role->level == 2 ? 'selected' : '' }}>Trạm trưởng</option>
                                    <option value="3" {{ $role->level == 3 ? 'selected' : '' }}>Nhân viên trạm y tế</option>
                                    <option value="4" {{ $role->level == 4 ? 'selected' : '' }}>Nhân viên ủy ban phường</option>
                                    <option value="5" {{ $role->level == 5 ? 'selected' : '' }}>Công dân sinh sống trong khu vực</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group d-flex" style="flex-direction: column" id="form-description">
                            <label for="description">Mô tả</label>
                            <div style="width: 100%;">
                                <textarea id="description" name="description" class="form-group">{{ $role->description }}</textarea>
                            </div>
                        </div>
                        <div class="checkbox form-group" id="form-is_active">         
                            <label>
                                <input type="checkbox" name="is_active" value="1" {{ $role->is_active == 1 ? 'checked' : ''}}>Trạng thái hiển thị 
                            </label>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <a href="javascript:void(0)" class="btn btn-primary edit-role" data-id="{{ $role->id }}">Sửa</a>
                        <button type="reset" class="btn btn-danger">Tải lại</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
        <!--/.col (right) -->
        <div class="col-md-5">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin Xã/Phường</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group" id="form-province">
                        <label>Tỉnh/Thành phố</label>
                        <div>
                            <select class="select2 form-control" style="width: 100%;" name="province_id" id="province_id">
                                <option value="">-- Chọn --</option>
                                @foreach ($provinces as $province)
                                <option value="{{ $province->id }}" {{ $role->belongsToWard->belongsToDistrict->belongsToProvince->id == $province->id ? 'selected' : '' }} >{{ $province->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group" id="form-district_id">
                        <label>Quận/Huyện</label>
                        <div>
                            <select class="select2 form-control" style="width: 100%;" name="district_id" id="district_id">
                                <option value="">-- Chọn --</option>
                                @foreach ($districts as $district)
                                <option value="{{ $district->id }}" {{ $role->belongsToWard->belongsToDistrict->id == $district->id ? 'selected' : '' }} >{{ $district->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group" id="form-ward_id">
                        <label>Xã/Phường</label>
                        <div>
                            <select class="select2 form-control" style="width: 100%;" name="ward_id" id="ward_id">
                                <option value="">-- Chọn --</option>
                                @foreach ($wards as $ward)
                                <option value="{{ $ward->id }}" {{ $role->belongsToWard->id == $ward->id ? ' selected' : '' }}>{{ $ward->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

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
<script src="/myAssets/js/role/create.js"></script>
@endsection