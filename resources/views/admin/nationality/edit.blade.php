@extends('admin.layouts.main')

@section('header_title')
<title>Medical Services | Nationalities</title>
@endsection

@section('content')

<section class="content-header">
    <h1>
        Sửa - Quốc tịch
        <small><a href="{{ route('admin.nationality.index') }}">Danh sách</a></small>
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
                                <input id="name" name="name" type="text" class="form-control" placeholder="Tên Quốc tịch" value="{{ $nationality->name }}">
                            </div>
                        </div>
                        <div class="form-group d-flex" id="form-abbreviation">
                            <label class="" for="abbreviation">Tên viết tắt</label>
                            <div>
                                <input id="abbreviation" name="abbreviation" type="text" class="form-control" placeholder="Tên viết tắt" value="{{ $nationality->abbreviation }}">
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <a href="javascript:void(0)" class="btn btn-primary edit-nationality" data-id="{{ $nationality->id }}">Edit</a>
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