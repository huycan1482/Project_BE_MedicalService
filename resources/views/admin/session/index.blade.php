@extends('admin.layouts.main')

@section('header_title')
<title>Medical Services | Sessions</title>
@endsection

@section('css')
<!-- DataTables -->
{{-- <link rel="stylesheet" href="AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css"> --}}
@endsection

@section('content')
<section class="content-header">
    <h1> Quản lý danh sách Buổi tiêm </h1>
</section>

<section class="content">
    <div class="row">    
        <div class="col-lg-12" style="margin-bottom: 10px">  
            <a class="btn bg-purple" href="{{ route('admin.session.create') }}">
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
                        {{-- <div class="col-lg-5">
                            <ul class="nav nav-pills nav-stacked">
                                <li>
                                    <a><h4>Tổng số lượng sản phẩm: <span class="badge bg-light-blue" style="margin-bottom: 3px"></span></h4></a>
                                </li>
                                <li>
                                    <a> Số lượng hàng khả dụng: <span class="badge bg-green" style="margin-bottom: 3px">  </span> 
                                    <div class="progress progress-xs progress-striped active">
                                        <div class="progress-bar progress-bar-success" style="width: 50%"></div>
                                    </div></a>
                                </li>
                                <li>
                                    <a> Số lượng hàng quá hạn: <span class="badge bg-yellow" style="margin-bottom: 3px"> </span> 
                                    <div class="progress progress-xs progress-striped active">
                                        <div class="progress-bar progress-bar-yellow" style="width: 50%"></div>
                                    </div></a>
                                </li>
                                <li>
                                    <a> Số lượng hàng bán hết: <span class="badge bg-red" style="margin-bottom: 3px"></span> 
                                    <div class="progress progress-xs progress-striped active">
                                        <div class="progress-bar progress-bar-danger" style="width: "></div>
                                    </div></a>
                                </li>
                            </ul>
                        </div> --}}
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
                    <h3 class="box-title">Danh sách<span class="label label-info" style="margin-left: 8px">{{ $sessions->total() }} kết quả</span></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">STT</th>
                                <th class="text-center">Thời gian bắt đầu</th>
                                <th class="text-center">Thời gian kết thúc</th>
                                <th class="text-center">Loại dịch bệnh</th>
                                <th class="text-center">Loại vaccine</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sessions as $key => $session)
                            <tr data-id={{ $session->id }}>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td class="text-center">{{ $session->start_at }}</td>
                                <td class="text-center">{{ $session->end_at }}</td>
                                <td class="text-center">{{ $session->belongsToDisease->name }}</td>
                                <td class="text-center">
                                    @foreach ($session->belongsToManyVaccines as $item)
                                        {{$item->name.','}}
                                    @endforeach
                                </td>
                                <td class="text-center">{{ $session->hasManyObject->count() }}</td>
                                <td class="text-center">
                                  
                                @if ($session->status_id == 0)
                                    <span class="label label-{{ 'warning' }}">{{'Hoãn'}}</span>
                                @elseif ($session->status_id == 1)
                                    <span class="label label-{{ 'danger' }}">{{'Chưa hoàn thành'}}</span>
                                @else 
                                    <span class="label label-{{ 'success' }}">{{'Hoàn thành'}}</span>
                                @endif
                                    
                                </td>
                                <td class="text-center" >
                                    <a href="{{ route('admin.object.listObjects', ['id' => $session->id]) }}" class="btn btn-primary btn-detail" title="Chi tiết"> 
                                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                                    </a>
                                    <a href="{{ route('admin.session.edit', ['id'=> $session->id]) }}" class="btn btn-warning" title="Sửa">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-danger" onclick="destroyModel('session', '{{ $session->id }}' )" title="Xóa">
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
                    {!! $sessions->links() !!}
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
                                <th class="text-center">Thời gian bắt đầu</th>
                                <th class="text-center">Thời gian kết thúc</th>
                                <th class="text-center">Số lượng</th>
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
<script src="/myAssets/js/myJS.js"></script>
<script src="/myAssets/js/notice.js"></script>
<script src="/myAssets/js/session/index.js"></script>
@endsection
