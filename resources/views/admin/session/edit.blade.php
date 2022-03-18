@extends('admin.layouts.main')

@section('header_title')
<title>Medical Services | Sessions</title>
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
                            <div class="form-group col-lg-12 d-flex" id="form-address">
                                <label class="" for="address">Địa điểm tiêm chi tiết<span class="required-dot">**</span></label>
                                <div>
                                    <input id="address" name="address" type="text" class="form-control" placeholder="Địa điểm chi tiết" value="{{ $session->address }}">
                                </div>
                            </div>
                            <div class="form-group d-flex col-lg-4" id="form-quantity">
                                <label class="" for="quantity">Số lượng dự kiến<span class="required-dot">**</span></label>
                                <div>
                                    <input id="quantity" name="quantity" type="number" class="form-control" placeholder="Số lượng dự kiến" value="{{ $session->quantity }}">
                                </div>
                            </div>
                            <div class="form-group d-flex col-lg-4" id="form-actual_quantity">
                                <label class="" for="actual_quantity">Số lượng thực tế<span class="required-dot">**</span></label>
                                <div>
                                    <input id="actual_quantity" name="actual_quantity" type="number" class="form-control" placeholder="Số lượng thực tế" value="{{ $session->actual_quantity }}">
                                </div>
                            </div>
                            <div class="form-group d-flex col-lg-4" id="form-status_id">
                                <label class="" for="status_id">Tình trạng <span class="required-dot">**</span></label>
                                <div>
                                    <select class="form-control" name="status_id" id="status_id">
                                        <option value="" selected disabled>--Chọn--</option>
                                        <option value="0" {{ $session->status_id == '0' ? ' selected' : ''}}>Hoãn</option>
                                        <option value="1" {{ $session->status_id == '1' ? ' selected' : ''}}>Chưa hoàn thành</option>
                                        <option value="2" {{ $session->status_id == '2' ? ' selected' : ''}}>Hoàn thành</option>
                                    </select>
                                </div>
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
<script src="/myAssets/js/myJS.js"></script>
<script src="/myAssets/js/notice.js"></script>
<script src="/myAssets/js/session/create.js"></script>
@endsection