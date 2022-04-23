@extends('admin.layouts.main')

@section('header_title')
<title>Medical Services | Object</title>
@endsection

@section('css')
<!-- DataTables -->
{{-- <link rel="stylesheet" href="AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css"> --}}
@endsection

@section('content')
<section class="content-header">
    <h1> Quản lý danh sách Đối tượng tiêm </h1>
</section>

<section class="content">
    {{-- modal nhập file excel --}}
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
                        <form action="{{ route('admin.import.object') }}" method="POST" name="" enctype="multipart/form-data">
                            @csrf
                            <label for="">Chọn file Excel</label><br>
                            <input name="import_file" type="file" class="custom-type-file" id="import-file"><br><br>
                            <button class="label-type-file btn btn-primary">Nhập file excel</button>
                            <input type="text" name="session_id" value="{{ $session_id }}" style="display: none">
                        </form>
                    </div>
                    <div>
                        @if($errors->any())
                            <h4>Dữ liệu không nhập thành công: {{ $errors->first('count_failed') }}</h4>
                            @foreach($errors->get('data_failed') as $item) 
                            <p>CCCD/CMT không nhập thành công: {{$item}}</p>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                </div>
            </div>
        </div>
    </div>

    {{-- modal thêm đối tượng --}}
    <div class="modal fade" id="modal-resident">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Thêm đối tượng vào buổi tiêm</h4>
                </div>
                <div class="modal-body">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Thông tin tìm kiếm</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-lg-6" id="form-indentity_card">
                                    <label class="" for="indentity_card">CCCD/CMT/Hộ chiếu</label>
                                    <div>
                                        <input name="indentity_card" type="text" class="form-control" placeholder="CCCD/CMT/Hộ chiếu">
                                    </div>
                                </div>
                                <div class="form-group col-lg-6" id="form-name">
                                    <label class="" for="name">Họ và tên</label>
                                    <div>
                                        <input name="name" type="text" class="form-control" placeholder="Họ và tên">
                                    </div>
                                </div>
                                <div class="form-group col-lg-6" id="form-date_of_birth">
                                    <label class="" for="date_of_birth">Ngày tháng năm sinh</label>
                                    <div>
                                        <input name="date_of_birth" type="date" class="form-control" placeholder="Ngày tháng năm sinh">
                                    </div>
                                </div>
                                <div class="form-group col-lg-6" id="form-phone">
                                    <label class="" for="phone">Số điện thoại</label>
                                    <div>
                                        <input name="phone" type="text" class="form-control" placeholder="Số điện thoại">
                                    </div>
                                </div>
                                <div class="form-group col-lg-4" id="form-province_id">
                                    <label>Tỉnh/Thành phố</label>
                                    <div>
                                        <select class="select2 form-control" style="width: 100%;" name="province_id" id="province_id">
                                            <option value="">-- Chọn --</option>
                                            @foreach ($provinces as $province)
                                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-lg-4" id="form-district_id">
                                    <label>Quận/Huyện</label>
                                    <div>
                                        <select class="select2 form-control" style="width: 100%;" name="district_id" id="district_id">
                                            <option value="">-- Chọn --</option>
                                            @foreach ($districts as $district)
                                            <option value="{{ $district->id }}">{{ $district->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-lg-4" id="form-ward_id">
                                    <label>Xã/Phường</label>
                                    <div>
                                        <select class="select2 form-control" style="width: 100%;" name="ward_id" id="ward_id">
                                            <option value="">-- Chọn --</option>
                                            @foreach ($wards as $ward)
                                            <option value="{{ $ward->id }}">{{ $ward->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <input name="session_id" type="text" class="session_id" value="{{ $session_id }}" style="display:none">
                                <div class="col-lg-12" style="text-align: center">
                                    <button type="button" class="btn btn-primary search-resident">Tìm kiếm</button>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        {{-- <th class="text-center">STT</th> --}}
                                        <th class="text-center">Họ và tên</th>
                                        <th class="text-center">Ngày sinh</th>
                                        <th class="text-center">Điện thoại</th>
                                        <th class="text-center">Địa chỉ</th>
                                        <th class="text-center">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody class="list-user">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Thêm</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                </div>
            </div>
        </div>
    </div>

    {{-- modal thêm mũi tiêm --}}
    <div class="modal fade" id="modal-injection">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Thêm mũi tiêm</h4>
                </div>
                <div class="modal-body">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Thông tin mũi tiêm</h3>
                        </div>
                        <div class="box-body">
                            <table id="" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">Vaccine</th>
                                        <th class="text-center">Mũi</th>
                                        <th class="text-center">Số lô vaccine</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>                                           
                                            <div>
                                                <select class="form-control select2" style="width: 100%;" name="vaccine_id" id="vaccine_id">
                                                    <option value="" selected disabled>-- Chọn --</option>
                                                    @foreach($vaccines as $vaccine)
                                                    <option value="{{ $vaccine->id }}">{{ $vaccine->name }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="text" name="disease_id" id="disease_id" value="{{ $disease_id }}" style="display:none">
                                            </div>
                                        </td>
                                        <td>                                           
                                            <div>
                                                <select class="form-control" style="width: 100%;" name="dose" id="dose">
                                                    <option value="" selected disabled>-- Chọn --</option>
                                                    <option value="1">Mũi 1</option>
                                                    <option value="2">Mũi 2</option>
                                                    <option value="3">Mũi 3</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>                                           
                                            <div>
                                                <select class="form-control select2" style="width: 100%;" name="pack_id" id="pack_id">
                                                    <option value="" selected disabled>-- Chọn --</option>
                                                </select>
                                            </div>
                                        </td>    
                                    </tr>
                                </tbody>
                            </table>
                            <table id="" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">Ngày tiêm</th>
                                        <th class="text-center">Loại đối tượng</th>
                                        <th class="text-center">Trạng thái</th>
                                        <th class="text-center">Cán bộ tiêm</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>                                           
                                            <div>
                                                <input class="form-control" type="date" name="created_at" id="created_at" placeholder="" value={{date('Y-m-d')}}>
                                            </div>
                                        </td>
                                        <td>                                           
                                            <div>
                                                <select class="select2 form-control" style="width: 100%;" name="priority_id" id="priority_id">
                                                    <option value="" selected disabled>-- Chọn --</option>
                                                    @foreach($priorities as $priority)
                                                    <option value="{{ $priority->id }}">{{ $priority->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td>                                           
                                            <div>
                                                <select class="form-control" style="width: 100%;" name="status_id" id="status_id">
                                                    <option value="" selected disabled>-- Chọn --</option>
                                                    <option value="1">Đã tiêm</option>
                                                    <option value="0">Chưa tiêm</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>                                           
                                            <div>
                                                <select class="form-control" style="width: 100%;" name="injector_id" id="injector_id">
                                                    <option value="" selected disabled>-- Chọn --</option>
                                                    @foreach($injectors as $injector)
                                                    <option value="{{ $injector->id }}">{{ $injector->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>                           
                        </div>
                    </div>
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Phản ứng sau tiêm</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group d-flex col-lg-6" id="form-name">
                                    <label class="" for="name">Phản ứng sau tiêm</label>
                                    <div>
                                        <select class="form-control" style="width: 100%;" name="reaction_id" id="reaction_id">
                                            <option value="" selected disabled>-- Chọn --</option>
                                            <option value="0">không có phản ứng</option>
                                            <option value="1">Có phản ứng</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group d-flex col-lg-6" id="form-name">
                                    <label class="" for="name">Cán bộ theo dõi</label>
                                    <div>
                                        <select class="form-control" style="width: 100%;" name="watcher_id" id="watcher_id">
                                            <option value="" selected disabled>-- Chọn --</option>
                                            @foreach($injectors as $injector)
                                            <option value="{{ $injector->id }}">{{ $injector->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group d-flex col-lg-12" id="form-description">
                                    <label class="" for="description">Ghi chú</label>
                                    <div>
                                        <textarea class="form-control" name="description" id="description" cols="30" rows="10"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="add-injection" data-id="{{$session_id}}">Thêm</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">    
        <div class="col-lg-12" style="margin-bottom: 10px">  
            <button class="btn bg-purple" data-toggle="modal" data-target="#modal-resident">
                <i class="fa-solid fa-plus"></i>
                <span style="margin-left: 5px">Thêm đối tượng tiêm trong buổi</span>
            </button>
            <button class="btn btn-success" data-toggle="modal" data-target="#modal-excel">
                <i class="fa-solid fa-file-excel"></i> 
                <span style="margin-left: 5px">Nhập file Excel</span>
            </button>
            @can('viewAny', App\User::class)
            <a class="btn btn-primary" href="{{ route('admin.object.trash', ['id' => $session_id]) }}">
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
                                <div class="col-lg-3">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    <label class="" for="name">Tìm kiếm theo tên</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Tìm kiếm theo tên" value="{{ $name }}">
                                </div>
                                <div class="col-lg-3">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    <label class="" for="identity">Tìm kiếm CCCD/CMT</label>
                                    <input type="text" class="form-control" name="identity" id="identity" placeholder="Tìm kiếm theo tên" value="{{ $identity }}">
                                </div>
                                <div class="col-lg-3">
                                    <i class="fa-solid fa-arrow-down-short-wide"></i>
                                    <label class="" for="sort">Sắp xếp</label>
                                    <select name="" id="sort" class="form-control">
                                        <option value="">--Chọn--</option>
                                        <option value="moi-nhat" {{ ($sort) == 'moi-nhat' ? 'selected' : ''}}>Ngày thêm mới nhất</option>
                                        <option value="cu-nhat" {{ ($sort) == 'cu-nhat' ? 'selected' : ''}}>Ngày thêm cũ nhất</option>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <i class="fa-regular fa-eye"></i>
                                    <label class="" for="status">Trạng thái</label>
                                    <select name="" id="status" class="form-control">
                                        <option value="">--Chọn--</option>
                                        <option value="da-tiem" {{ ($status == 'da-tiem') ? 'selected' : ''}}>Đã tiêm</option>
                                        <option value="chua-tiem" {{ ($status == 'chua-tiem') ? 'selected' : ''}}>Chưa tiêm</option>
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
                    <h3 class="box-title">Danh sách<span class="label label-info" style="margin-left: 8px">{{ $objects->total() }} kết quả</span></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">STT</th>
                                <th class="text-center">Họ và tên</th>
                                <th class="text-center">Ngày sinh</th>
                                <th class="text-center">CCCD/CMT</th>
                                <th class="text-center">Địa chỉ</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($objects as $key => $object)
                            <tr class="item-{{ $object->id }}">
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td class="">{{ $object->belongsToResident->name }}</td>
                                <td class="text-center">{{ $object->belongsToResident->date_of_birth }}</td>
                                <td class="text-center">{{ $object->belongsToResident->identity_card }}</td>
                                <td class="">{{ $object->belongsToResident->address }}</td>
                                <td class="text-center">
                                    <span class="label label-{{ ($object->status_id == 1) ? 'success' : 'danger' }}">{{ ($object->status_id == 1) ? 'Đã tiêm' : 'Chưa tiêm' }}</span>
                                </td>
                                <td class="text-center">
                                    @if($object->status_id == 0) 
                                        <button type="button" class="btn btn-primary btn-detail" id="btn-active-modal-injection" data-toggle="modal" data-target="#modal-injection" title="Chi tiết" object-id="{{$object->id}}" resident-id="{{$object->belongsToResident->id}}">
                                            <i class="fa-solid fa-pencil"></i>
                                        </button>
                                    @else
                                        <a href="{{ route('admin.resident.listInjections', ['id'=> $object->resident_id]) }}" class="btn btn-success" title="Chi tiết">
                                            <i class="fa-solid fa-vial-circle-check"></i>
                                        </a>
                                    @endif
                                    <a href="javascript:void(0)" class="btn btn-danger" onclick="destroyModel('object', '{{ $object->id }}' )" title="Xóa">
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
                    {!! $objects->links() !!}
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
    <!-- /.row -->
</section>
@endsection

@section('js')
<script src="/AdminLTE/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="/myAssets/js/myJS.js"></script>
<script src="/myAssets/js/notice.js"></script>
<script src="/myAssets/js/object/index.js"></script>
@endsection
