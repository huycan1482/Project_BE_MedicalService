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
    <h1> Quản lý danh sách mũi tiêm của {{$resident->name}} </h1>
</section>

<section class="content">

    <div class="row">    
        <div class="col-lg-12" style="margin-bottom: 10px">  
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
                                    <label class="" for="disease">Tìm kiếm theo dịch bệnh</label>
                                    <select class=" select2 form-control" style="width: 100%;" name="disease" id="disease">
                                        <option value="">-- Chọn --</option>
                                        @foreach ($diseases as $disease)
                                        <option value="{{ $disease->id }}" {{ ($disease->id == $disease_id) ? ' selected="selected"' : '' }}>{{ $disease->name }}</option>
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
                    <h3 class="box-title">Danh sách</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">STT</th>
                                <th class="text-center">Loại bệnh</th>
                                <th class="text-center">Loại vaccine</th>
                                <th class="text-center">Lô vaccine</th>
                                <th class="text-center">Mũi</th>
                                <th class="text-center">Ngày tiêm</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="list-injection">
                            @foreach($list_injections as $key => $item)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td class="vaccine-{{ $item->vaccine_id }}">{{$item->disease_name}}</td>
                                <td>{{ $item->vaccine_name }}</td>
                                <td>{{ $item->pack_name }}</td>
                                <td class="text-center">{{ $item->dose }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.injection.edit', ['id'=> $item->injection_id]) }}" class="btn btn-warning" title="Sửa">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- /.box-body -->
                </div>
                <div class="box-footer" style="display: flex; justify-content: flex-end">
                    
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
<script src="/AdminLTE/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="/myAssets/js/myJS.js"></script>
<script src="/myAssets/js/notice.js"></script>
<script src="/myAssets/js/injection/index.js"></script>
@endsection
