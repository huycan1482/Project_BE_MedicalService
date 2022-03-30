@extends('admin.layouts.main')

@section('header_title')
<title>Medical Services | Sessions</title>
@endsection

@section('css')
<!-- Theme style -->
<link rel="stylesheet" href="AdminLTE/dist/css/AdminLTE.min.css">
@endsection

@section('content')
<section class="content-header">
    <h1>
        Sửa - Buổi tiêm
        <small>
            <a href="{{ route('admin.session.index') }}"><span class="label label-success">Danh sách</span></a>
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
                    <h3 class="box-title">Thông tin Buổi tiêm</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="">

                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-lg-6 d-flex" id="form-start_at">
                                <label class="" for="start_at">Thời gian bắt đầu<span class="required-dot">**</span></label>
                                <div>
                                    <input id="start_at" name="start_at" type="date" class="form-control" placeholder="Thời gian bắt đầu" value="{{ $session->start_at }}">
                                </div>
                            </div>
                            <div class="form-group col-lg-6 d-flex" id="form-end_at">
                                <label class="" for="end_at">Thời gian kết thúc<span class="required-dot">**</span></label>
                                <div>
                                    <input id="end_at" name="end_at" type="date" class="form-control" placeholder="Thời gian kết thúc" value="{{ $session->end_at }}">
                                </div>
                            </div>
                            <div class="form-group col-lg-6 d-flex" id="form-address">
                                <label class="" for="address">Địa điểm tiêm chi tiết<span class="required-dot">**</span></label>
                                <div>
                                    <input id="address" name="address" type="text" class="form-control" placeholder="Địa điểm chi tiết" value="{{ $session->address }}">
                                </div>
                            </div>
                            
                            <div class="form-group d-flex col-lg-6" id="form-status_id">
                                <label class="" for="status_id">Tình trạng <span class="required-dot">**</span></label>
                                <div>
                                    <select class="form-control" name="status_id" id="status_id">
                                        <option value="" selected disabled>--Chọn--</option>
                                        <option value="0" {{$session->status_id == 0 ? 'selected' : ''}}>Hoãn</option>
                                        <option value="1" {{$session->status_id == 1 ? 'selected' : ''}}>Chưa hoàn thành</option>
                                        <option value="2" {{$session->status_id == 2 ? 'selected' : ''}}>Hoàn thành</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-lg-6 " id="form-disease_id">
                                <label for="">Chọn dịch bệnh <span class="required-dot">**</span></label>
                                    <select class="form-control select2" data-placeholder="Chọn dịch bệnh" style="width: 100%;" name="disease_id" id="disease_id">
                                        <option value="">-- Chọn --</option>
                                        @foreach ($diseases as $disease)
                                        <option value="{{ $disease->id }}" {{ $session->disease_id == $disease->id ? 'selected' : '' }}>{{ $disease->name }}</option>
                                        @endforeach
                                    </select>
                            </div>
                            <div class="form-group col-lg-6" id="form-vaccine_id">
                                <label for="">Chọn Vaccine <span class="required-dot">**</span></label>
                                    <select class="form-control select2" multiple="multiple" data-placeholder="Chọn vaccine" style="width: 100%;" name="vaccine_id" id="vaccine_id">
                                        <option value="">-- Chọn --</option>
                                        @foreach ($vaccines as $vaccine)
                                        <option value="{{ $vaccine->id }}" {{ $session->belongsToManyVaccines->contains("id", $vaccine->id) ? 'selected' : '' }}>{{ $vaccine->name }}</option>
                                        @endforeach
                                    </select>
                            </div>
                        </div>
                        
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <a href="javascript:void(0)" class="btn btn-primary edit-session" data-id="{{ $session->id }}">Sửa</a>
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
<script src="/myAssets/js/session/create.js"></script>
@endsection