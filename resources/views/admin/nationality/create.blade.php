@extends('admin.layouts.main')

@section('header_title')
<title>Medical Services | Nationalities</title>
@endsection

@section('content')

<section class="content-header">
    <h1>
        Thêm - Quốc tịch
        <small>
            <a href="{{ route('admin.nationality.index') }}"><span class="label label-success">Danh sách</span></a>
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
                    <h3 class="box-title">Thông tin Quốc tịch</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="">

                    <div class="box-body">
                        <div class="form-group d-flex" id="form-name">
                            <label class="" for="name">Tên Quốc tịch</label>
                            <div>
                                <input id="name" name="name" type="text" class="form-control" placeholder="Tên Quốc tịch">
                            </div>
                        </div>
                        <div class="form-group d-flex" id="form-abbreviation">
                            <label class="" for="abbreviation">Tên viết tắt</label>
                            <div>
                                <input id="abbreviation" name="abbreviation" type="text" class="form-control" placeholder="Tên viết tắt">
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
                        <a href="javascript:void(0)" class="btn btn-primary add-nationality">Add</a>
                        <button type="reset" class="btn btn-danger">Reset</button>
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
<script src="/myAssets/js/nationality/create.js"></script>
@endsection