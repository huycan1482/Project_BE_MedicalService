@extends('admin.layouts.main')

@section('header_title')
<title>Medical Services | Ethnics</title>
@endsection

@section('css')
<!-- DataTables -->
{{-- <link rel="stylesheet" href="AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css"> --}}
@endsection

@section('content')
<section class="content-header">
    <h1> Quản lý danh sách Dân tộc đã xóa</h1>
</section>

<section class="content">
    <div class="row">    
        <div class="col-lg-12" style="margin-bottom: 10px">  
            <a class="btn bg-purple" href="{{ route('admin.ethnic.index') }}">
                <i class="fa fa-solid fa-list"></i>
                <span style="margin-left: 5px">Danh sách</span>
            </a>
            {{-- <button class="btn btn-success" data-toggle="modal" data-target="#modal-excel">
                <i class="fa-solid fa-file-excel"></i> 
                <span style="margin-left: 5px">Nhập file Excel</span>
            </button> --}}
            @can('viewAny', App\User::class)
            <a class="btn btn-primary" href="{{ route('admin.ethnic.trash') }}">
                <i class="fa fa-trash"></i>
                <span style="margin-left: 5px">Danh sách đã xóa</span>
            </a>
            @endcan
            <button class="btn btn-flat bg-navy" onclick="reloadPage()">
                <i class="fa-solid fa-arrows-rotate"></i>
                <span style="margin-left: 5px">Tải lại</span>
            </button>
        </div>

        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Lọc dữ liệu</h3>

                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <form action="" class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-4">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    <label class="" for="name">Tìm kiếm theo tên</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Tìm kiếm theo tên" value="{{ $name }}">
                                </div>
                                <div class="col-lg-4">
                                    <i class="fa-solid fa-arrow-down-short-wide"></i>
                                    <label class="" for="sort">Sắp xếp</label>
                                    <select name="" id="sort" class="form-control">
                                        <option value="">--Chọn--</option>
                                        <option value="moi-nhat" {{ !empty($sort) == 'moi-nhat' ? 'selected' : ''}}>Ngày thêm mới nhất</option>
                                        <option value="cu-nhat" {{ !empty($sort) == 'cu-nhat' ? 'selected' : ''}}>Ngày thêm cũ nhất</option>
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <i class="fa-regular fa-eye"></i>
                                    <label class="" for="status">Trạng thái</label>
                                    <select name="" id="status" class="form-control">
                                        <option value="">--Chọn--</option>
                                        <option value="hien-thi" {{ !empty($status) == 'hien-thi' ? 'selected' : ''}}>Hiển thị</option>
                                        <option value="an" {{ !empty($status) == 'an' ? 'selected' : ''}}>Ẩn</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer" style="display: flex; justify-content: flex-end">
                    <button type="submit" class="btn btn-info btn-filter">
                        <i class="fa-solid fa-filter"></i> 
                        <span style="margin-left: 5px">Lọc dữ liệu</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Danh sách<span class="label label-info" style="margin-left: 8px">{{ $ethnics->total() }} kết quả</span></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">STT</th>
                                <th class="text-center">Tên dân tộc</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ethnics as $key => $ethnic)
                            <tr class="item-{{ $ethnic->id }}">
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td class="">{{ $ethnic->name }}</td>
                                <td class="text-center">
                                    <span class="label label-{{ ($ethnic->is_active == 1) ? 'success' : 'danger' }}">{{ ($ethnic->is_active == 1) ? 'Hiển thị' : 'Ẩn' }}</span>
                                </td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" onclick="restore('ethnic/restore', '{{ $ethnic->id }}' )" class="btn btn-primary" title="Khôi phục">
                                        <i class="fas fa-trash-restore"></i>
                                    </a>

                                    <a href="javascript:void(0)" onclick = "forceDelete('ethnic/forceDelete', '{{ $ethnic->id }}' )" class="btn btn-danger" title="Xóa">
                                        <i class="fas fa-ban"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- /.box-body -->
                </div>
                <div class="box-footer" style="display: flex; justify-content: flex-end">
                    {!! $ethnics->links() !!}
                </div>
                <!-- /.box -->
            </div>
        </div>

    </div>
    <!-- /.row -->
</section>
@endsection

@section('js')
<script src="/myAssets/js/myJS.js"></script>
<script src="/myAssets/js/notice.js"></script>
<script src="/myAssets/js/ethnic/index.js"></script>
@endsection
