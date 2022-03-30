@extends('admin.layouts.main')

@section('header_title')
<title>Medical Services | Resident</title>
@endsection

@section('css')
<!-- DataTables -->
{{-- <link rel="stylesheet" href="AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css"> --}}
@endsection

@section('content')
<section class="content-header">
    <h1> Quản lý danh sách Dân cư </h1>
</section>

<section class="content">

    <div class="row">    
        <div class="col-lg-12" style="margin-bottom: 10px">  
            <a class="btn bg-purple" href="{{ route('admin.resident.create') }}">
                <i class="fa-solid fa-plus"></i>
                <span style="margin-left: 5px">Thêm mới</span>
            </a>
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
                                <div class="col-lg-6" style="margin-bottom: 10px">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    <label class="" for="name">Tìm kiếm theo tên</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Tìm kiếm theo tên" value="{{ $name }}">
                                </div>
                                <div class="col-lg-6" style="margin-bottom: 10px">
                                    <i class="fa fa-envelope"></i>
                                    <label class="" for="email">Tìm kiếm theo Email</label>
                                    <input type="text" class="form-control" name="email" id="email" placeholder="Tìm kiếm theo email" value="{{ $email }}">
                                </div>
                                <div class="col-lg-4">
                                    <i class="fa-solid fa-arrow-down-short-wide"></i>
                                    <label class="" for="sort">Sắp xếp</label>
                                    <select name="" id="sort" class="form-control">
                                        <option value="">--Chọn--</option>
                                        <option value="moi-nhat" {{ $sort == 'moi-nhat' ? 'selected' : ''}}>Ngày thêm mới nhất</option>
                                        <option value="cu-nhat" {{ $sort == 'cu-nhat' ? 'selected' : ''}}>Ngày thêm cũ nhất</option>
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <i class="fa-regular fa-eye"></i>
                                    <label class="" for="status">Trạng thái</label>
                                    <select name="" id="status" class="form-control">
                                        <option value="">--Chọn--</option>
                                        <option value="hien-thi" {{ $status == 'hien-thi' ? 'selected' : ''}}>Hiển thị</option>
                                        <option value="an" {{ $status == 'an' ? 'selected' : ''}}>Ẩn</option>
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <i class="fa fa-solid fa-layer-group"></i>
                                    <label class="" for="level">Cấp độ</label>
                                    <select name="" id="level" class="form-control">
                                        <option value="">--Chọn--</option>
                                        <option value="Admin" {{ $level == 'Admin' ? 'selected' : ''}}>Admin</option>
                                        <option value="Tram-truong" {{ $level == 'Tram-truong' ? 'selected' : ''}}>Trạm trưởng</option>
                                        <option value="Nhan-vien-tram-y-te" {{ $level == 'Nhan-vien-tram-y-te' ? 'selected' : ''}}>Nhân viên trạm y tế</option>
                                        <option value="Nhan-vien-uy-ban-phuong" {{ $level == 'Nhan-vien-uy-ban-phuong' ? 'selected' : ''}}>Nhân viên ủy ban phường</option>
                                    </select>
                                </div>
                                <div class="col-lg-12" style="margin-top: 15px">
                                    <label style="color: #2980b9">Lọc theo địa bàn quản lý</label>
                                </div>
                                <div class="col-lg-4">
                                    <i class="fa fa-solid fa-map"></i>
                                    <label class="" for="province">Tỉnh/Thành phố</label>
                                    <select name="" id="province" class="form-control select2">
                                        <option value="">--Chọn--</option>
                                        @foreach ($provinces as $index)
                                        <option value="{{ $index->id }}" {{ $province == $index->id ? 'selected' : '' }}>{{ $index->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <i class="fa fa-solid fa-map-location-dot"></i>
                                    <label class="" for="district">Quận/Huyện</label>
                                    <select name="" id="district" class="form-control select2">
                                        <option value="">--Chọn--</option>
                                        @foreach ($districts as $index)
                                        <option value="{{ $index->id }}" {{ $district == $index->id ? 'selected' : '' }}>{{ $index->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <i class="fa fa-solid fa-map-pin"></i>
                                    <label class="" for="ward">Xã/Phường</label>
                                    <select name="" id="ward" class="form-control select2">
                                        <option value="">--Chọn--</option>
                                        @foreach ($wards as $index)
                                        <option value="{{ $index->id }}" {{ $ward == $index->id ? 'selected' : '' }}>{{ $index->name }}</option>
                                        @endforeach
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
                    <h3 class="box-title">Danh sách<span class="label label-info" style="margin-left: 8px">{{ $residents->total() }} kết quả</span></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">STT</th>
                                <th class="text-center">Tên</th>
                                <th class="text-center">SDT</th>
                                <th class="text-center">Xã/phường quản lý</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($residents as $key => $resident)
                            <tr data-id={{ $resident->id }}>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td class="">{{ $resident->name }}</td>
                                <td class="">{{ $resident->phone }}</td>
                                <td class="">{{ $resident->belongsToWard->name }}</td>
                                <td class="text-center">
                                    <span class="label label-{{ ($resident->is_active == 1) ? 'success' : 'danger' }}">{{ ($resident->is_active == 1) ? 'Hiển thị' : 'Ẩn' }}</span>
                                </td>
                                <td class="text-center">

                                    {{-- <button type="button" class="btn btn-primary btn-detail" data-toggle="modal" data-target="" title="Chi tiết" data-id="{{$resident->id}}">
                                        <i class="fa-solid fa-eye"></i>
                                    </button> --}}

                                    <a href="{{ route('admin.resident.listInjections', ['id'=> $resident->id]) }}" class="btn btn-primary" title="Chi tiết">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>

                                    <a href="{{ route('admin.resident.edit', ['id'=> $resident->id]) }}" class="btn btn-warning" title="Sửa">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>

                                    <a href="javascript:void(0)" class="btn btn-danger" onclick="destroyModel('resident', '{{ $resident->id }}' )" title="Xóa">
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
                    {!! $residents->links() !!}
                </div>
                <!-- /.box -->
            </div>
        </div>

        <div class="col-lg-12">
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
                                <th class="text-center">Tên</th>
                                <th class="text-center">Trạng thái</th>
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
{{-- <script src="AdminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js"></script> --}}
{{-- <script src="AdminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> --}}
<script src="/AdminLTE/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="/myAssets/js/myJS.js"></script>
<script src="/myAssets/js/notice.js"></script>
<script src="/myAssets/js/resident/index.js"></script>
@endsection
