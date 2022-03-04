@extends('admin.layouts.main')

@section('header_title')
<title>Medical Services | Diseases</title>
@endsection

@section('content')

<section class="content-header">
    <h1>
        Sửa - Dịch bệnh
        <small>
            <a href="{{ route('admin.disease.index') }}"><span class="label label-success">Danh sách</span></a>
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
                    <h3 class="box-title">Thông tin Dịch bệnh</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="">

                    <div class="box-body">
                        <div class="form-group d-flex" id="form-name">
                            <label class="" for="name">Tên dịch bệnh</label>
                            <div>
                                <input id="name" name="name" type="text" class="form-control" placeholder="Tên dịch bệnh" value="{{ $disease->name }}">
                            </div>
                        </div>
                        <div class="form-group d-flex" style="flex-direction: column" id="form-description">
                            <label for="description">Mô tả</label>
                            <div style="width: 100%;">
                                <textarea id="description" name="description" class="form-group">{{ $disease->description }}</textarea>
                            </div>
                        </div>
                        <div class="checkbox form-group" id="form-is_active">         
                            <label>
                                <input type="checkbox" name="is_active" value="1" {{ $disease->is_active == 1 ? 'checked' : '' }}>Trạng thái hiển thị 
                            </label>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <a href="javascript:void(0)" class="btn btn-primary edit-disease" data-id="{{ $disease->id }}">Sửa</a>
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
<script src="/myAssets/js/disease/create.js"></script>
@endsection