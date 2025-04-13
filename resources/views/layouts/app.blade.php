<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Cache-Control" content="no-store" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Quản lý thiết bị">
    <!-- Favicon -->
    <link rel="shortcut icon" href="images/logo.png">
    <title>@yield('title', 'Trang chủ')</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <!-- Toastr style -->
    <link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">
    <!-- JQuery UI -->
    <link href="js/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet">
    <!-- Data Tables -->
    <link href="css/plugins/dataTables/datatables.min.css" rel="stylesheet">
    <!-- Custom styles -->
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style2.css" rel="stylesheet">
    @yield('css')
</head>

<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <span>
                                <img alt="image" class="img-circle" src="images/logo.png" width="30px" height="30px" />
                            </span>
                            <a href="{{ route('home') }}">
                                <span class="clear">
                                    <span class="block m-t-xs">
                                        <strong class="font-bold">QUẢN LÝ THIẾT BỊ</strong>
                                    </span>
                                </span>
                            </a>
                        </div>
                        <div class="logo-element">
                            <img alt="image" class="img-circle" src="images/logo.png" width="30px" height="30px" />
                        </div>
                    </li>

                    {{-- Quản lý đơn vị --}}
                    @php $menu1 = request()->is('donvi*') || request()->is('phongkho*'); @endphp
                    <li class="{{ $menu1 ? 'active' : '' }}">
                        <a href="#"><i class="fa fa-th-large"></i>
                            <span class="nav-label">Quản lý đơn vị</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level {{ $menu1 ? 'in' : 'collapse' }}">
                            <li class="{{ request()->is('donvi*') ? 'active' : '' }}"><a href="{{ route('donvi.index') }}">Đơn vị</a></li>
                            <li class="{{ request()->is('phongkho*') ? 'active' : '' }}"><a href="{{ route('phongkho.index') }}">Phòng-kho</a></li>
                        </ul>
                    </li>

                    {{-- Quản lý người dùng --}}
                    @php $menu2 = request()->is('loaitaikhoan*') || request()->is('taikhoan*'); @endphp
                    <li class="{{ $menu2 ? 'active' : '' }}">
                        <a href="#"><i class="fa fa-th-large"></i>
                            <span class="nav-label">Quản lý người dùng</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level {{ $menu2 ? 'in' : 'collapse' }}">
                            <li class="{{ request()->is('loaitaikhoan*') ? 'active' : '' }}"><a href="{{ route('loaitaikhoan.index') }}">Loại tài khoản</a></li>
                            <li class="{{ request()->is('taikhoan*') ? 'active' : '' }}"><a href="{{ route('taikhoan.index') }}">Danh sách tài khoản</a></li>
                            <li><a href="#">Lịch sử truy cập</a></li>
                        </ul>
                    </li>

                    {{-- Đồ nội thất --}}
                    @php $menu3 = request()->is('noithat*'); @endphp
                    <li class="{{ $menu3 ? 'active' : '' }}">
                        <a href="#"><i class="fa fa-sitemap"></i>
                            <span class="nav-label">Đồ nội thất</span><span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level {{ $menu3 ? 'in' : 'collapse' }}">
                            <li><a href="#">Loại đồ nội thất</a></li>
                            <li><a href="#">Danh sách nội thất</a></li>
                            <li><a href="#">Danh mục kiểm kê</a></li>
                        </ul>
                    </li>

                    {{-- Biểu mẫu --}}
                    @php $menu4 = request()->is('bieumau*'); @endphp
                    <li class="{{ $menu4 ? 'active' : '' }}">
                        <a href="#"><i class="fa fa-sitemap"></i>
                            <span class="nav-label">Biểu mẫu</span><span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level {{ $menu4 ? 'in' : 'collapse' }}">
                            <li><a href="#">Biểu mẫu thiết bị</a></li>
                            <li><a href="#">Biểu mẫu đồ nội thất</a></li>
                            <li><a href="#">Sổ quản lý kho</a></li>
                            <li><a href="#">Nhật ký phòng máy</a></li>
                        </ul>
                    </li>

                    {{-- Ghi sổ nhật ký --}}
                    @php $menu5 = request()->is('nhatkyphongmay*') || request()->is('hocky*') || request()->is('nhatkythietbi*'); @endphp
                    <li class="{{ $menu5 ? 'active' : '' }}">
                        <a href="#"><i class="fa fa-sitemap"></i>
                            <span class="nav-label">Ghi sổ nhật ký</span><span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level {{ $menu5 ? 'in' : 'collapse' }}">
                            <li><a href="#">Quản lý học kỳ</a></li>
                            <li class="{{ request()->is('nhatkyphongmay*') ? 'active' : '' }}">
                                <a href="{{ route('nhatkyphongmay.index') }}">Nhật ký phòng máy</a>
                            </li>
                            <li><a href="#">Sổ quản lý kho</a></li>
                            <li><a href="#">Nhật ký từng loại thiết bị</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
        </nav>
        <div id="page-wrapper" class="gray-bg dashbard-1">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                        <!-- <form role="search" class="navbar-form-custom" action="search_results.html">
                            <div class="form-group">
                                <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                            </div>
                        </form> -->
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <a href="#"
                                onclick="event.preventDefault();sessionStorage.removeItem('welcomeMessageShown'); document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out"></i> Đăng xuất
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="dashboard-header">
                @yield('content')
            </div>
            @include('layouts.footer')
        </div>
    </div>
    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
    <!-- jQuery UI -->
    <script src="js/plugins/toastr/toastr.min.js"></script>
    <script src="js/plugins/dataTables/datatables.min.js"></script>

    @yield('js')
    @include('layouts.toast')
</body>

</html>