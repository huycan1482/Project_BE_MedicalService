@extends('admin.layouts.main')

@section('header_title')
<title>Medical Services | Users</title>
@endsection

@section('content')

<section class="content-header">
    <h1>
        Sửa - Mũi tiêm của ({{$injection->belongsToResident->name}})
        <small>
            <a href="{{ route('admin.resident.listInjections', ['id'=> $injection->resident_id]) }}"><span class="label label-success">Danh sách mũi tiêm</span></a>
        </small>
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin chung </h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="">

                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-lg-3" id="form-start_at">
                                <label>Ngày bắt đầu buổi tiêm</label>
                                <div>
                                    <input id="" name="" type="text" class="form-control" value="{{ date_format(date_create($injection->belongsToObject->belongsToSession->start_at), 'd/m/Y') }}" disabled>
                                </div>
                            </div>

                            <div class="form-group col-lg-3" id="form-end_at">
                                <label>Ngày kết thúc buổi tiêm</label>
                                <div>
                                    <input id="" name="" type="text" class="form-control" value="{{ date_format(date_create($injection->belongsToObject->belongsToSession->end_at), 'd/m/Y') }}" disabled>
                                </div>
                            </div>
                            <div class="form-group col-lg-3" id="form-address">
                                <label>Địa chỉ</label>
                                <div>
                                    <input id="" name="" type="text" class="form-control" value="{{ $injection->belongsToObject->belongsToSession->address }}" disabled>
                                </div>
                            </div>
                            <div class="form-group col-lg-3" id="form-type">
                                <label>Loại mũi tiêm</label>
                                <div>
                                    <select class="select2 form-control" style="width: 100%;" name="type" id="type">
                                        <option value="">-- Chọn --</option>
                                        <option value="0" {{ $injection->type == 0 ? 'selected' : ''}}>Thêm nhanh</option>
                                        <option value="1" {{ $injection->type == 1 ? 'selected' : ''}}>Thêm thường</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </form>
            </div>
            <!-- /.box -->
        </div>

        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin mũi tiêm</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="">

                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-lg-4" id="form-vaccine_id">
                                <label>Vaccine</label>
                                <div>
                                    <select class="form-control" style="width: 100%;" name="vaccine_id" id="vaccine_id">
                                        <option value="">-- Chọn --</option>
                                        @foreach ($vaccines as $vaccine)
                                        <option value="{{ $vaccine->id }}" {{ $injection->belongsToPack->belongsToVaccine->id == $vaccine->id ? ' selected="selected"' : '' }}>{{ $vaccine->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-lg-4" id="form-pack_id">
                                <label>Lô vaccine</label>
                                <div>
                                    <select class="select2 form-control" style="width: 100%;" name="pack_id" id="pack_id">
                                        <option value="">-- Chọn --</option>
                                        @foreach ($packs as $pack)
                                        <option value="{{ $pack->id }}" {{ $injection->pack_id == $pack->id ? ' selected="selected"' : '' }}>{{ $pack->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-lg-4" id="form-dose">
                                <label>Mũi</label>
                                <div>
                                    <select class="form-control" style="width: 100%;" name="dose" id="dose">
                                        <option value="">-- Chọn --</option>
                                        <option value="1" {{$injection->dose == 1 ? 'selected' : ''}}>Mũi 1</option>
                                        <option value="2" {{$injection->dose == 2 ? 'selected' : ''}}>Mũi 2</option>
                                        <option value="3" {{$injection->dose == 3 ? 'selected' : ''}}>Mũi 3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-lg-3" id="form-created_at">
                                <label>Ngày tiêm</label>
                                <div>
                                    <input id="created_at" name="created_at" type="date" class="form-control" value="{{ date_format(date_create($injection->date), 'Y-m-d') }}">
                                </div>
                                {{-- value="{{ date_format(date_create($injection->created_at), 'd/m/Y') }}" --}}
                            </div>
                            <div class="form-group col-lg-3" id="form-priority_id">
                                <label>Loại đối tượng tiêm</label>
                                <div>
                                    <select class="select2 form-control" style="width: 100%;" name="priority_id" id="priority_id">
                                        <option value="">-- Chọn --</option>
                                        @foreach ($priorities as $priority)
                                        <option value="{{ $priority->id }}" {{ $injection->priority_id == $priority->id ? ' selected="selected"' : '' }}>{{ $priority->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-lg-3" id="form-">
                                <label>Trạng thái</label>
                                <div>
                                    <input id="date" name="date" type="text" class="form-control" placeholder="Ngày tiêm" value="Đã tiêm" disabled>
                                </div>
                            </div>
                            <div class="form-group col-lg-3" id="form-injector_id">
                                <label>Người tiêm</label>
                                <div>
                                    <select class="select2 form-control" style="width: 100%;" name="injector_id" id="injector_id">
                                        <option value="">-- Chọn --</option>
                                        @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ $injection->injector_id == $user->id ? ' selected="selected"' : '' }}>{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
        
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin sau tiêm </h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="">

                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-lg-6" id="form-reaction_id">
                                <label>Phản ứng sau tiêm</label>
                                <div>
                                    <select class="form-control" style="width: 100%;" name="reaction_id" id="reaction_id">
                                        <option value="">-- Chọn --</option>
                                        <option value="0" {{$injection->reaction_id == 0 ? 'selected' : ''}}>Không có phản ứng</option>
                                        <option value="1" {{$injection->reaction_id == 1 ? 'selected' : ''}}>Có phản ứng</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-lg-6" id="form-watcher_id">
                                <label>Cán bộ theo dõi</label>
                                <div>
                                    <select class="select2 form-control" style="width: 100%;" name="watcher_id" id="watcher_id">
                                        <option value="">-- Chọn --</option>
                                        @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ $injection->watcher_id == $user->id ? ' selected="selected"' : '' }}>{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-lg-12" id="form-description">
                                <label>Ghi chú</label>
                                <div>
                                    <textarea class="form-control" id="description" name="description" cols="30" rows="10">{{ $injection->description }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <a href="javascript:void(0)" class="btn btn-primary edit-injection" data-id="{{ $injection->id }}">Sửa</a>
                        <button type="reset" class="btn btn-danger">Tải lại</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
        
    </div>
    <!-- /.row -->
</section>
@endsection

@section('js')
<script src="/AdminLTE/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="/myAssets/js/myJS.js"></script>
<script src="/myAssets/js/notice.js"></script>
<script src="/myAssets/js/injection/create.js"></script>
@endsection