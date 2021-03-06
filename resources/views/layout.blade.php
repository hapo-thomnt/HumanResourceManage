<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Human Resources</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('css')
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- my style -->
    <link href="{{ asset('css/mystyle.css') }}" rel="stylesheet" type="text/css"/>
</head>
<body class="hold-transition sidebar-mini layout-footer-fixed">
<!-- Site wrapper -->
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="../../index3.html" class="nav-link">Home</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">Contact</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
                    <i class="fas fa-th-large"></i>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="https://haposoft.com/vi" class="brand-link">
            <span class="brand-text font-weight-light">Haposoft</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img class="avatar" src="{{ asset(config('app.file_path').auth()->user()->avatar) }}" alt="avatar">
                </div>
                <div class="info">
                    <a href="{{ route('employees.edit',auth()->user()->id)}}" class="d-block">{{auth()->user()->lastname}} {{auth()->user()->firstname }}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
{{--                    <li class="nav-item">--}}
{{--                        <a href="../widgets.html" class="nav-link">--}}
{{--                            <i class="nav-icon fas fa-th"></i>--}}
{{--                            <p>--}}
{{--                                Home--}}
{{--                                <span class="right badge badge-danger">New</span>--}}
{{--                            </p>--}}
{{--                        </a>--}}
{{--                    </li>--}}
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-chart-pie"></i>
                            <p>
                                Báo cáo
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('reports.create')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Đăng ký báo cáo</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('reports.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Danh sách báo cáo</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('tasks.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Danh sách các task cần làm</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-tree"></i>
                            <p>
                                Nhân viên
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('employees.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Danh sách nhân viên</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('employees.create')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Đăng ký nhân viên mới</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-tree"></i>
                            <p>
                                Khách hàng
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('customers.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Danh sách khách hàng</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('customers.create')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Đăng ký khách hàng mới</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-tree"></i>
                            <p>
                                Công ty
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('companies.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Danh sách các công ty</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('companies.create')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Đăng ký công ty mới</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-tree"></i>
                            <p>
                                Dự án
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('projects.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Danh sách dự án</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('projects.create')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Đăng ký dự án mới</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>

                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield('content')
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 3.0.0-beta.2
        </div>
        <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
        reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('js/app.js') }}"></script>
@yield('js')
</body>
</html>
