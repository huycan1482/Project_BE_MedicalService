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
    <h1> Quản lý danh sách Buổi tiêm đã xóa </h1>
</section>

<section class="content">
    <div class="row">    
        <div class="col-lg-12" style="margin-bottom: 10px">  
            <a class="btn btn-primary" href="{{ route('admin.session.index') }}">
                <i class="fa fa-solid fa-list"></i>
                <span style="margin-left: 5px">Danh sách</span>
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
                                <div class="col-lg-3">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    <label class="" for="start_at">Tìm kiếm theo ngày bắt đầu</label>
                                    <input type="date" class="form-control" id="start_at" placeholder="Tìm kiếm theo tên" value="{{ $start_at }}">
                                </div>
                                <div class="col-lg-3">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    <label class="" for="end_at">Tìm kiếm theo ngày kết thúc</label>
                                    <input type="date" class="form-control" id="end_at" placeholder="Tìm kiếm theo tên" value="{{ $end_at }}">
                                </div>
                                <div class="col-lg-3">
                                    <i class="fa-solid fa-arrow-down-short-wide"></i>
                                    <label class="" for="sort">Sắp xếp</label>
                                    <select name="" id="sort" class="form-control">
                                        <option value="">--Chọn--</option>
                                        <option value="moi-nhat" {{ ($sort) == 'moi-nhat' ? 'selected' : ''}}>Ngày tạo mới nhất</option>
                                        <option value="cu-nhat" {{ ($sort) == 'cu-nhat' ? 'selected' : ''}}>Ngày tạo cũ nhất</option>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <i class="fa-regular fa-eye"></i>
                                    <label class="" for="status">Trạng thái</label>
                                    <select name="" id="status" class="form-control">
                                        <option value="">--Chọn--</option>
                                        <option value="hoan-thanh" {{ ($status) == 'hoan-thanh' ? 'selected' : ''}}>Hoàn thành</option>
                                        <option value="chua-hoan-thanh" {{ ($status) == 'chua-hoan-thanh' ? 'selected' : ''}}>Chưa hoàn thành</option>
                                        <option value="hoan" {{ ($status) == 'hoan' ? 'selected' : ''}}>Hoãn</option>
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
                                <th class="text-center">Xã/Phường quản lý</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sessions as $key => $session)
                            <tr class="item-{{ $session->id }}">
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td class="text-center">{{ $session->start_at }}</td>
                                <td class="text-center">{{ $session->end_at }}</td>
                                <td class="text-center">{{ $session->belongsToDiseaseWithTrashed->name }}</td>
                                <td class="text-center">
                                    @foreach ($session->belongsToManyVaccines as $item)
                                        {{$item->name.','}}
                                    @endforeach
                                </td>
                                <td class="text-center">{{ $session->hasManyObject->count() }}</td>
                                <td class="text-center">{{ $session->belongsToWardWithTrashed->name }}</td>
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
                                    <a href="javascript:void(0)" onclick="restore('session/restore', '{{ $session->id }}' )" class="btn btn-primary" title="Khôi phục">
                                        <i class="fas fa-trash-restore"></i>
                                    </a>

                                    <a href="javascript:void(0)" onclick = "forceDelete('session/forceDelete', '{{ $session->id }}' )" class="btn btn-danger" title="Xóa">
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
                    {!! $sessions->links() !!}
                </div>
                <!-- /.box -->
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
