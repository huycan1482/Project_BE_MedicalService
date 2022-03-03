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
        {{-- <small><a href="{{ route('admin.nationality.create') }}">Thêm mới</a></small> --}}
    </h1>
</section>

<section class="content">

    <div class="modal fade" id="modal-excel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Nhập dữ liệu qua file Excel</h4>
                </div>
                <div class="modal-body">
                    <div class="custom-import">
                        <form action="{{ route('admin.import.nationality') }}" method="POST" name="" enctype="multipart/form-data">
                            @csrf
                            <label for="">Chọn file Excel</label><br>
                            <input name="import_file" type="file" class="custom-type-file" id="import-file"><br><br>
                            <button class="label-type-file btn btn-primary">Nhập file excel</button>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12" style="margin-bottom: 10px">  
            <a class="btn btn-info" href="{{ route('admin.nationality.create') }}">
                <i class="fa-solid fa-plus"></i>
                <span style="margin-left: 5px">Thêm mới</span>
            </a>
            <button class="btn btn-success" data-toggle="modal" data-target="#modal-excel">
                <i class="fa-solid fa-file-excel"></i> 
                <span style="margin-left: 5px">Nhập file Excel</span>
            </button>
            <button class="btn btn-flat bg-navy" onclick="reloadPage()">
                <i class="fa-solid fa-arrows-rotate"></i>
                <span style="margin-left: 5px">Tải lại</span>
            </button>
        </div>

        <div class="col-lg-7">
            <div class="box box-primary">
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
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($nationalities as $key => $nationality)
                            <tr data-id={{ $nationality->id }}>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td class="">{{ $nationality->name }}</td>
                                <td class="text-center">{{ $nationality->abbreviation }}</td>
                                <td class="text-center">
                                    <span class="label label-{{ ($nationality->is_active == 1) ? 'success' : 'danger' }}">{{ ($nationality->is_active == 1) ? 'Hiển thị' : 'Ẩn' }}</span>
                                </td>
                                <td class="text-center">

                                    <button type="button" class="btn btn-primary btn-detail" data-toggle="modal" data-target="" title="Chi tiết" data-id="{{$nationality->id}}">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>

                                    <a href="{{ route('admin.nationality.edit', ['id'=> $nationality->id]) }}" class="btn btn-warning" title="Sửa">
                                        <i class="fa-solid fa-pencil"></i>
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

        <div class="col-lg-5">
            <div class="box box-danger">
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
