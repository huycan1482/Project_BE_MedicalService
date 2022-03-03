@extends('admin.layouts.main')

@section('header_title')
<title>Medical Services | Wards</title>
@endsection

@section('content')

<section class="content-header">
    <h1>
        Sửa - Xã, Phường
        <small>
            <a href="{{ route('admin.ward.index') }}"><span class="label label-success">Danh sách</span></a>
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
                    <h3 class="box-title">Thông tin Xã, Phường</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="">
                    <div class="box-body">
                        <div class="form-group d-flex" id="form-name">
                            <label class="" for="name">Tên Xã, Phường</label>
                            <div>
                                <input id="name" name="name" type="text" class="form-control" placeholder="Tên Xã/Phường" value="{{ $ward->name }}">
                            </div>
                        </div>
                        <div class="form-group" id="form-district_id">
                            <label>Quận/Huyện</label>
                            <div>
                                <select class=" select2 form-control" style="width: 100%;" name="district_id" id="district_id">
                                    <option value="">-- Chọn --</option>
                                    @foreach ($districts as $district)
                                    <option value="{{ $district->id }}" {{ ($district->id == $ward->district_id) ? 'selected' : '' }}>{{ $district->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="checkbox form-group" id="form-is_active">         
                            <label>
                                <input type="checkbox" name="is_active" value="1" {{ ($ward->is_active == 1) ? 'checked' : '' }}>Trạng thái hiển thị 
                            </label>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <a href="javascript:void(0)" class="btn btn-primary edit-ward" data-id="{{ $ward->id }}">Sửa</a>
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
<script src="/myAssets/js/ward/create.js"></script>
@endsection