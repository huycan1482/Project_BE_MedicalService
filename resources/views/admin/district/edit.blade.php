@extends('admin.layouts.main')

@section('header_title')
<title>Medical Services | District</title>
@endsection

@section('content')

<section class="content-header">
    <h1>
        Sửa - Quận, Huyện
        <small>
            <a href="{{ route('admin.district.index') }}"><span class="label label-success">Danh sách</span></a>
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
                    <h3 class="box-title">Thông tin Quận, Huyện</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="">
                    <div class="box-body">
                        <div class="form-group d-flex" id="form-name">
                            <label class="" for="name">Tên Quận/Huyện</label>
                            <div>
                                <input id="name" name="name" type="text" class="form-control" placeholder="Tên Quận/Huyện" value="{{ $district->name }}">
                            </div>
                        </div>
                        <div class="form-group" id="form-province_id">
                            <label>Tỉnh/Thành phố</label>
                            <div>
                                <select class=" select2 form-control" style="width: 100%;" name="province_id" id="province_id">
                                    <option value="">-- Chọn --</option>
                                    @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}" {{ ($province->id == $district->province_id) ? 'selected' : ''}}>{{ $province->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="checkbox form-group" id="form-is_active">         
                            <label>
                                <input type="checkbox" name="is_active" value="1" {{ ($district->is_active == 1) ? 'checked' : ''}}>Trạng thái hiển thị 
                            </label>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <a href="javascript:void(0)" class="btn btn-primary edit-district" data-id="{{ $district->id }}">Sửa</a>
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
<script src="/myAssets/js/district/create.js"></script>
@endsection