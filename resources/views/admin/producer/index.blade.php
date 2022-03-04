@extends('admin.layouts.main')

@section('header_title')
<title>Medical Services | Producers</title>
@endsection

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@endsection

@section('content')
<section class="content-header">
    <h1>
        Quản lý danh sách Nhà sản xuất
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-lg-12" style="margin-bottom: 10px">  
            <a class="btn btn-info" href="{{ route('admin.producer.create') }}">
                <i class="fa-solid fa-plus"></i>
                <span style="margin-left: 5px">Thêm mới</span>
            </a>
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
                                <th class="text-center">Tên nhà sản xuất</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($producers as $key => $producer)
                            <tr data-id={{ $producer->id }}>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td class="">{{ $producer->name }}</td>
                                <td class="text-center">
                                    <span class="label label-{{ ($producer->is_active == 1) ? 'success' : 'danger' }}">{{ ($producer->is_active == 1) ? 'Hiển thị' : 'Ẩn' }}</span>
                                </td>
                                <td class="text-center">

                                    <button type="button" class="btn btn-primary btn-detail" data-toggle="modal" data-target="" title="Chi tiết" data-id="{{$producer->id}}">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>

                                    <a href="{{ route('admin.producer.edit', ['id'=> $producer->id]) }}" class="btn btn-warning" title="Sửa">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>

                                    <a href="javascript:void(0)" class="btn btn-danger" onclick="destroyModel('producer', '{{ $producer->id }}' )" title="Xóa">
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
                    {!! $producers->links() !!}
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
                                <th class="text-center">Tên nhà sản xuất</th>
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
@endsection
