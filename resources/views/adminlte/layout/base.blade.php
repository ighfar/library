<?php
$get_route = Route::current()->action['as'];
$status = isset($status) ? $status : 0;
?>
<!DOCTYPE html>
<html>
<head>
    @section('head')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ env('WEBSITE_NAME') }} | @yield('title')</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    @show

    @section('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @show

    @section('script-top')
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    @show

</head>
<body class="hold-transition @yield('body-class')">
<div class="wrapper">

    @section('header')
    <header class="main-header">

        <!-- Logo -->
        <a href="{{ route('admin') }}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>{{ substr(env('WEBSITE_NAME'), 0, 2) }}</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>{{ env('WEBSITE_NAME') }}</b></span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="hidden-xs">{{ session('admin_name')  }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{ route('admin.get_profile') }}" class="btn btn-default btn-flat">{{ __('general.profile') }}</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ route('admin.logout') }}" class="btn btn-default btn-flat">{{ __('general.sign_out') }}</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <aside class="main-sidebar">
        <section class="sidebar">
            <!-- Sidebar Menu -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">MAIN NAVIGATION</li>

                <li class="{{ strpos($get_route, 'admin.purchase.') === 0 || strpos($get_route, 'admin.buku.') === 0 ? 'active' : '' }}">
                    <a href="{{ route('admin.buku.index') }}" title="{{ __('general.buku') }}">
                        <i class="fa fa-credit-card"></i> <span>{{ __('general.buku') }}</span>
                    </a>
                </li>
                <li class="{{ strpos($get_route, 'admin.report.') === 0 ? 'active' : '' }}">
                    <a href="{{ route('admin.report.index') }}" title="{{ __('general.report') }}">
                        <i class="fa fa-book"></i> <span>{{ __('general.report') }}</span>
                    </a>
                </li>

                @php
                    $list_setting = [
                        'transaksi',
                        'anggota'
                    ];
                @endphp
                @php
                    $active = '';
                    foreach ($list_setting as $setting) {
                        if (strpos($get_route, 'admin.'.$setting.'.') === 0) {
                            $active = 'active';
                        }
                    }
                @endphp
                <li class="treeview {{ $active }}">
                    <a href="#">
                        <i class="fa fa-gears"></i> <span>{{ __('general.setting') }}</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        @foreach ($list_setting as $setting)
                            <li class="{{ strpos($get_route, 'admin.'.$setting.'.') === 0 ? 'active' : '' }}">
                                <a href="{{ route('admin.'.$setting.'.index') }}" title="{{ __('general.'.$setting) }}">
                                    <i class="fa fa-circle-o"></i> <span>{{ __('general.'.$setting) }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>

                <li>
                    <a href="{{ route('admin.logout') }}">
                        <i class="fa fa-sign-out"></i> <span>{{ __('general.sign_out') }}</span>
                    </a>
                </li>
            </ul>
            <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>
    @show

    @yield('content')

    @section('footer')
    <footer class="main-footer">
        <strong>Copyright &copy; {{ date('Y') }} <a href="#">{{ env('WEBSITE_NAME') }}</a>.</strong> All rights reserved.
    </footer>
    @show

</div>
<!-- ./wrapper -->

@section('script-bottom')
<script src="{{ asset('js/app.js') }}"></script>
<script>
    function formatMoney(amount, decimalCount) {
        return amount.toFixed(decimalCount).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }
</script>
@show

</body>
</html>