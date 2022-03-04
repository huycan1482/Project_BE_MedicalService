<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                {{-- <p>{{ Auth::user()->name }}</p> --}}
                <p>Name</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        {{-- <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i
                            class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form> --}}
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">MAIN NAVIGATION</li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-solid fa-list"></i> <span>Quản lý danh mục</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    {{-- <li class="active"><a href="index.html"><i class="fa fa-circle-o"></i>Quản lý quốc tịch</a></li> --}}
                    <li>
                        <a href="{{ route('admin.nationality.index') }}"><i class="fa fa-solid fa-globe"></i> Quản lý quốc tịch</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.province.index') }}"><i class="fa fa-solid fa-map"></i> Quản lý Tỉnh/Thành phố</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.district.index') }}"><i class="fa fa-solid fa-map-location-dot"></i> Quản lý Quận/Huyện</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.ward.index') }}"><i class="fa fa-solid fa-map-pin"></i> Quản lý Xã/phường</a>
                    </li>
                </ul>
            </li>
            
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-solid fa-syringe"></i> <span>Quản lý tiêm chủng</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{ route('admin.disease.index') }}"><i class="fa fa-solid fa-virus-covid"></i> <span>Quản lý dịch bệnh</span></a>
                    </li>
                    <li>
                        <a href="{{ route('admin.producer.index') }}"><i class="fa fa-solid fa-user-tie"></i> Quản lý Nhà sản xuất</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.province.index') }}"><i class="fa fa-solid fa-vial"></i> Quản lý loại vaccine</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.district.index') }}"><i class="fa fa-solid fa-barcode"></i></i> Quản lí mã đối tượng ưu tiên</a>
                    </li>
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
