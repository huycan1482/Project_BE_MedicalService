@extends('admin.layouts.main')

@section('header_title')
<title>Medical Services | Nationalies</title>
@endsection

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@endsection

@section('content')
<section class="content-header">
    <h1>
        Quản lý danh sách Quốc tịch
        <small><a href="{{ route('admin.nationality.create') }}">Thêm mới</a></small>
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-lg-12">  
            <div class="custom-import">
                <form action="{{ route('admin.import.nationality') }}" method="POST" name="" enctype="multipart/form-data">
                    @csrf
                    <input name="import_file" type="file" class="custom-type-file" id="import-file">
                    <button class="label-type-file btn btn-success">Nhập file excel</button>
                </form>
            </div>
        </div>

        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Danh sách</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">STT</th>
                                <th class="text-center">Tên quốc tịch</th>
                                <th class="text-center">Tên viết tắt</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($nationalities as $key => $nationality)
                            <tr data-id={{ $nationality->id }}>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td class="text-center">{{ $nationality->name }}</td>
                                <td class="text-center">{{ $nationality->abbreviation }}</td>
                                <td class="text-center">

                                    <button type="button" class="btn btn-warning btn-detail" data-toggle="modal" data-target="#modal-default" title="Chi tiết" data-id="{{$nationality->id}}">
                                        <i class="fas fa-cog"></i>
                                    </button>

                                    <a href="{{ route('admin.nationality.edit', ['id'=> $nationality->id]) }}" class="btn btn-success" title="Sửa">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <a href="javascript:void(0)" class="btn btn-danger" onclick="destroyModel('nationality', '{{ $nationality->id }}' )" title="Xóa">
                                        <i class="fa fa-trash"></i>
                                    </a>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- /.box-body -->
                </div>
                <div class="box-footer" style="display: flex; justify-content: flex-end">
                    {!! $nationalities->links() !!}
                </div>
                <!-- /.box -->
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title" style="display: inline; margin-right: 5px">Danh sách đã bị xóa </h3>
                    <small>(Tải lại sau khi xóa mềm)</small>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">STT</th>
                                <th class="text-center">Tên quốc tịch</th>
                                <th class="text-center">Tên viết tắt</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
</section>
@endsection

@section('js')
<script src="AdminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="AdminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="/myAssets/js/myJS.js"></script>
<script src="/myAssets/js/notice.js"></script>
<script src="/myAssets/js/nationality/create.js"></script>
<script>
    $(function () {
        // $('#example1').DataTable();
    });
</script>

@endsection
