@extends('admin.layouts.main')

@section('header_title')
<title>Medical Services | Vaccines</title>
@endsection

@section('css')
<!-- Theme style -->
<link rel="stylesheet" href="AdminLTE/dist/css/AdminLTE.min.css">
@endsection

@section('content')

<section class="content-header">
    <h1>
        Thêm - Vaccine
        <small>
            <a href="{{ route('admin.vaccine.index') }}"><span class="label label-success">Danh sách</span></a>
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
                    <h3 class="box-title">Thông tin Vaccine</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="">

                    <div class="box-body">
                        <div class="form-group d-flex" id="form-name">
                            <label class="" for="name">Tên vaccine</label>
                            <div>
                                <input id="name" name="name" type="text" class="form-control" placeholder="Tên vaccine">
                            </div>
                        </div>
                        <div class="form-group" id="form-disease_id">
                            <label for="">Chọn dịch bệnh</label>

                            <div class=""">
                                <select class="form-control select2" multiple="multiple" data-placeholder="Chọn dịch bệnh" style="width: 100%;" name="disease_id" id="disease_id">
                                    <option value="">-- Chọn --</option>
                                    @foreach ($diseases as $disease)
                                    <option value="{{ $disease->id }}">{{ $disease->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="form-producer_id">
                            <label for="">Chọn nhà sản xuất</label>

                            <div class="">
                                <select class="form-control select2" multiple="multiple" data-placeholder="Chọn nhà sản xuất" style="width: 100%;" name="producer_id" id="producer_id">
                                    <option value="">-- Chọn --</option>
                                    @foreach ($producers as $producer)
                                    <option value="{{ $producer->id }}">{{ $producer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group d-flex" style="flex-direction: column" id="form-description">
                            <label for="description">Mô tả</label>
                            <div style="width: 100%;">
                                <textarea id="description" name="description" class="form-group"></textarea>
                            </div>
                        </div>
                        <div class="checkbox form-group" id="form-is_active">         
                            <label>
                                <input type="checkbox" name="is_active" value="1">Trạng thái hiển thị 
                            </label>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <a href="javascript:void(0)" class="btn btn-primary add-vaccine">Thêm</a>
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
<script src="/myAssets/js/vaccine/create.js"></script>
@endsection