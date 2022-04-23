@extends('admin.layouts.main')

@section('header_title')
<title>Medical Services | Nationalies</title>
@endsection

@section('css')
<!-- DataTables -->
{{-- <link rel="stylesheet" href="AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css"> --}}
@endsection

@section('content')
<section class="content-header">
    <h1> Quản lý thống kê </h1>
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
                                <div class="col-lg-3">
                                    <i class="fa fa-solid fa-map"></i>
                                    <label class="" for="province">Dịch bệnh</label>
                                    <select name="" id="disease" class="form-control select2">
                                        <option value="">--Chọn--</option>
                                        @foreach ($diseases as $index)
                                        <option value="{{ $index->id }}" {{ $disease == $index->id ? 'selected' : '' }}>{{ $index->name }}</option>
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
                    <h3 class="box-title">Thống kê</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div id="piechart-1" style="width: 100%; height: 500px;"></div>
                        </div>
                        <div class="col-lg-6">
                            <div id="piechart-2" style="width: 100%; height: 500px;"></div>
                            
                        </div>
                    </div>
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
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="/myAssets/js/myJS.js"></script>
<script src="/myAssets/js/notice.js"></script>
<script src="/myAssets/js/statistic/index.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data_1 = google.visualization.arrayToDataTable([
        ['Thống kê đã tiêm', 'Toàn bộ thời gian'],
        {!! $html_statistic1 !!}
        ]);

        var options_1 = {
          title: 'Biểu đồ % đã tiêm/chưa tiêm ít nhất 1 mũi theo dịch bệnh'
        };

        var chart_1 = new google.visualization.PieChart(document.getElementById('piechart-1'));

        chart_1.draw(data_1, options_1);

        var data_2 = google.visualization.arrayToDataTable([
        ['Thống kê đã tiêm', 'Toàn bộ thời gian'],
        {!! $html_statistic2 !!}
        ]);

        var options_2 = {
          title: 'Biểu đồ đã tiêm theo độ tuổi'
        };

        var chart_2 = new google.visualization.PieChart(document.getElementById('piechart-2'));

        chart_2.draw(data_2, options_2);
    }
</script>
@endsection
