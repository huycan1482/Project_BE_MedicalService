@extends('admin.layouts.main')

@section('header_title')
<title>Medical Services | Sessions</title>
@endsection

@section('content')

<section class="content-header">
    <h1>
        Thêm - Buổi tiêm
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
                                    <input id="start_at" name="start_at" type="date" class="form-control" placeholder="Thời gian bắt đầu">
                                </div>
                            </div>
                            <div class="form-group col-lg-6 d-flex" id="form-end_at">
                                <label class="" for="end_at">Thời gian kết thúc<span class="required-dot">**</span></label>
                                <div>
                                    <input id="end_at" name="end_at" type="date" class="form-control" placeholder="Thời gian kết thúc">
                                </div>
                            </div>
                            <div class="form-group col-lg-12 d-flex" id="form-address">
                                <label class="" for="address">Địa điểm tiêm chi tiết<span class="required-dot">**</span></label>
                                <div>
                                    <input id="address" name="address" type="text" class="form-control" placeholder="Địa điểm chi tiết">
                                </div>
                            </div>
                            <div class="form-group d-flex col-lg-4" id="form-quantity">
                                <label class="" for="quantity">Số lượng dự kiến<span class="required-dot">**</span></label>
                                <div>
                                    <input id="quantity" name="quantity" type="number" class="form-control" placeholder="Số lượng dự kiến">
                                </div>
                            </div>
                            <div class="form-group d-flex col-lg-4" id="form-actual_quantity">
                                <label class="" for="actual_quantity">Số lượng thực tế<span class="required-dot">**</span></label>
                                <div>
                                    <input id="actual_quantity" name="actual_quantity" type="number" class="form-control" placeholder="Số lượng thực tế">
                                </div>
                            </div>
                            <div class="form-group d-flex col-lg-4" id="form-status_id">
                                <label class="" for="status_id">Tình trạng <span class="required-dot">**</span></label>
                                <div>
                                    <select class="form-control" name="status_id" id="status_id">
                                        <option value="" selected disabled>--Chọn--</option>
                                        <option value="0">Hoãn</option>
                                        <option value="1">Chưa hoàn thành</option>
                                        <option value="2">Hoàn thành</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <a href="javascript:void(0)" class="btn btn-primary add-session">Thêm</a>
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