@extends('admin.layouts.main')

@section('header_title')
<title>Medical Services | Provinces</title>
@endsection

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@endsection

@section('content')
<section class="content-header">
    <h1>
        Quản lý danh sách Tỉnh/Thành phố
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
                        <form action="{{ route('admin.import.province') }}" method="POST" name="" enctype="multipart/form-data">
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
            <a class="btn bg-purple" href="{{ route('admin.province.create') }}">
                <i class="fa-solid fa-plus"></i>
                <span style="margin-left: 5px">Thêm mới</span>
            </a>
            <button class="btn btn-success" data-toggle="modal" data-target="#modal-excel">
                <i class="fa-solid fa-file-excel"></i> 
                <span style="margin-left: 5px">Nhập file Excel</span>
            </button>
            @can('viewAny', App\User::class)
            <a class="btn btn-primary" href="{{ route('admin.province.trash') }}">
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
                    <h3 class="box-title">Danh sách<span class="label label-primary" style="margin-left: 8px">{{ $provinces->total() }} kết quả</span></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">STT</th>
                                <th class="text-center">Tên Tỉnh/Thành phố</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($provinces as $key => $province)
                            <tr class="item-{{ $province->id }}">
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td class="">{{ $province->name }}</td>
                                <td class="text-center">
                                    <span class="label label-{{ ($province->is_active == 1) ? 'success' : 'danger' }}">{{ ($province->is_active == 1) ? 'Hiển thị' : 'Ẩn' }}</span>
                                </td>
                                <td class="text-center">
                                    {{-- <button type="button" class="btn btn-primary btn-detail" data-toggle="modal" data-target="" title="Chi tiết" data-id="{{$province->id}}">
                                        <i class="fa-solid fa-eye"></i>
                                    </button> --}}

                                    <a href="{{ route('admin.province.edit', ['id'=> $province->id]) }}" class="btn btn-warning" title="Sửa">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>

                                    @can('viewAny', App\User::class)
                                    <a href="javascript:void(0)" class="btn btn-danger" onclick="destroyModel('province', '{{ $province->id }}' )" title="Xóa">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    @endcan

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- /.box-body -->
                </div>
                <div class="box-footer" style="display: flex; justify-content: flex-end">
                    {!! $provinces->links() !!}
                </div>
                <!-- /.box -->
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
<script src="/myAssets/js/province/index.js"></script>

@endsection
