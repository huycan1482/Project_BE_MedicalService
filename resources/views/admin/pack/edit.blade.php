@extends('admin.layouts.main')

@section('header_title')
<title>Medical Services | Packs</title>
@endsection

@section('content')

<section class="content-header">
    <h1>
        Sửa - Lô vaccine 
        <small>
            <a href="{{ route('admin.pack.index') }}"><span class="label label-success">Danh sách</span></a>
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
                    <h3 class="box-title">Thông tin Lô vaccine</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="">

                    <div class="box-body">
                        <div class="form-group d-flex" id="form-name">
                            <label class="" for="name">Tên Lô vaccine</label>
                            <div>
                                <input id="name" name="name" type="text" class="form-control" placeholder="Tên Lô vaccine" value="{{ $pack->name }}">
                            </div>
                        </div>
                        <div class="form-group d-flex" id="form-expired">
                            <label class="" for="expired">Hạn sử dụng</label>
                            <div>
                                <input id="expired" name="expired" type="date" class="form-control" placeholder="Hạn sử dụng" value="{{ $pack->expired }}">
                            </div>
                        </div>
                        <div class="form-group" id="form-vaccine_id">
                            <label>Loại Vaccine</label>
                            <div>
                                <select class="select2 form-control" style="width: 100%;" name="vaccine_id" id="vaccine_id">
                                    <option value="">-- Chọn --</option>
                                    @foreach ($vaccines as $vaccine)
                                    <option value="{{ $vaccine->id }}" {{ $pack->vaccine_id == $vaccine->id ? 'selected' : ''}} >{{ $vaccine->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="form-producer_id">
                            <label>Nhà sản xuất</label>
                            <div>
                                <select class="select2 form-control" style="width: 100%;" name="producer_id" id="producer_id">
                                    <option value="">-- Chọn --</option>
                                    @foreach($producers as $producer)
                                    <option value="{{ $producer->id }}" {{ $producer->id == $pack->producer_id ? 'selected' : ''}}>{{ $producer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="checkbox form-group" id="form-is_active">         
                            <label>
                                <input type="checkbox" name="is_active" value="1" {{ $pack->is_active == 1 ? 'checked' : '' }}>Trạng thái hiển thị 
                            </label>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <a href="javascript:void(0)" class="btn btn-primary edit-pack" data-id="{{ $pack->id }}">Sửa</a>
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
<script src="/myAssets/js/pack/create.js"></script>
@endsection