@extends('admin.layouts.main')

@section('header_title')
<title>Medical Services | Users</title>
@endsection

@section('content')

<section class="content-header">
    <h1>
        Sửa - Mũi tiêm
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
                    <h3 class="box-title">Thông tin mũi tiêm của {{$injection->belongsToResident->name}}</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="">

                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-lg-4" id="form-vaccine_id">
                                <label>Vaccine</label>
                                <div>
                                    <select class="select2 form-control" style="width: 100%;" name="vaccine_id" id="vaccine_id">
                                        <option value="">-- Chọn --</option>
                                        @foreach ($vaccines as $vaccine)
                                        <option value="{{ $vaccine->id }}">{{ $vaccine->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-lg-4" id="form-dose">
                                <label>Vaccine</label>
                                <div>
                                    <select class="select2 form-control" style="width: 100%;" name="dose" id="dose">
                                        <option value="">-- Chọn --</option>
                                        <option value="1">Mũi 1</option>
                                        <option value="2">Mũi 2</option>
                                        <option value="3">Mũi 3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-lg-4" id="form-dose">
                                <label>Vaccine</label>
                                <div>
                                    <select class="select2 form-control" style="width: 100%;" name="dose" id="dose">
                                        <option value="">-- Chọn --</option>
                                        <option value="1">Mũi 1</option>
                                        <option value="2">Mũi 2</option>
                                        <option value="3">Mũi 3</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <a href="javascript:void(0)" class="btn btn-primary edit-injection" data-id="{{ $injection->id }}">Sửa</a>
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
<script src="/myAssets/js/injection/create.js"></script>
@endsection