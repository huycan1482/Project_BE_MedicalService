<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="myAssets/image/avatar.png" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">{{ Auth::user()->belongsToRole->name }}</li>

            @can('viewAny', App\User::class)
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
                        <a href="{{ route('admin.nationality.index') }}"><i class="fa fa-solid fa-globe"></i><span> Quản lý quốc tịch</span></a>
                    </li>
                    <li>
                        <a href="{{ route('admin.ethnic.index') }}"><i class="fa fa-solid fa-people-group"></i><span> Quản lý dân tộc</span></a>
                    </li>
                    <li>
                        <a href="{{ route('admin.province.index') }}"><i class="fa fa-solid fa-map"></i><span> Quản lý Tỉnh/Thành phố</span></a>
                    </li>
                    <li>
                        <a href="{{ route('admin.district.index') }}"><i class="fa fa-solid fa-map-location-dot"></i><span> Quản lý Quận/Huyện</span></a>
                    </li>
                    <li>
                        <a href="{{ route('admin.ward.index') }}"><i class="fa fa-solid fa-map-pin"></i><span> Quản lý Xã/phường</span></a>
                    </li>
                </ul>
            </li>
            @endcan

            @can('viewAny', App\User::class)
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-solid fa-vial-virus"></i><span>Quản lý Vaccine</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{ route('admin.disease.index') }}"><i class="fa fa-solid fa-virus-covid"></i><span> Quản lý dịch bệnh</span></a>
                    </li>
                    <li>
                        <a href="{{ route('admin.producer.index') }}"><i class="fa fa-solid fa-user-tie"></i><span> Quản lý Nhà sản xuất</span></a>
                    </li>
                    <li>
                        <a href="{{ route('admin.vaccine.index') }}"><i class="fa fa-solid fa-vial"></i><span> Quản lý loại vaccine</span></a>
                    </li>
                    <li>
                        <a href="{{ route('admin.pack.index') }}"><i class="fa fa-solid fa-box-archive"></i><span> Quản lý lô vaccine</span></a>
                    </li>
                    <li>
                        <a href="{{ route('admin.priority.index') }}"><i class="fa fa-solid fa-barcode"></i><span> Quản lí mã đối tượng ưu tiên</span></a>
                    </li>
                </ul>
            </li>
            @endcan

            @can('viewAny', App\Resident::class)
            <li>
                <a href="{{ route('admin.resident.index') }}"><i class="fa fa-solid fa-users"></i> <span>Quản lí dân cư</span></a>
            </li>
            @endcan

            @can('viewAny', App\Session::class)
            <li>
                <a href="{{ route('admin.session.index') }}"><i class="fa fa-solid fa-list-check"></i><span> Quản lý buổi tiêm</span></a>
            </li>
            @endcan

            @can('viewAny', App\User::class)
            <li>
                <a href="{{ route('admin.role.index') }}"><i class="fa fa-solid fa-layer-group"></i> <span>Quản lí quyền</span></a>
            </li>
            @endcan

            @can('view', App\User::class)
            <li>
                <a href="{{ route('admin.user.index') }}"><i class="fa fa-solid fa-users-gear"></i> <span>Quản lí người dùng</span></a>
            </li>
            @endcan
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
