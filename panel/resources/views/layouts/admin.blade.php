<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{ config('app.name', 'Cardinals') }} - @yield('title')</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="_token" content="{{ csrf_token() }}">

        <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png">
        <link rel="icon" type="image/png" href="/favicons/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="/favicons/favicon-16x16.png" sizes="16x16">
        <link rel="manifest" href="/favicons/manifest.json">
        <link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#bc6e3c">
        <link rel="shortcut icon" href="/favicons/favicon.ico">
        <meta name="msapplication-config" content="/favicons/browserconfig.xml">
        <meta name="theme-color" content="#0e4688">

        @include('layouts.scripts')

        @section('scripts')
            {!! Theme::css('vendor/select2/select2.min.css?t={cache-version}') !!}
            {!! Theme::css('vendor/bootstrap/bootstrap.min.css?t={cache-version}') !!}
            {!! Theme::css('vendor/adminlte/admin.min.css?t={cache-version}') !!}
            {!! Theme::css('vendor/adminlte/colors/skin-blue.min.css?t={cache-version}') !!}
            {!! Theme::css('vendor/sweetalert/sweetalert.min.css?t={cache-version}') !!}
            {!! Theme::css('vendor/animate/animate.min.css?t={cache-version}') !!}
            {!! Theme::css('css/pterodactyl.css?t={cache-version}') !!}
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
            <style>
                /* ── Cardinals Admin Theme — Red & Black ── */
                :root {
                    --cr: #CC0000;
                    --cr-dark: #8B0000;
                    --cb: #0d0d0d;
                    --cs: #1a1a1a;
                    --cm: #222;
                    --ct: #f0f0f0;
                }

                /* Overall background */
                body, .wrapper { background-color: #111 !important; }

                /* ── Top navbar ── */
                .main-header .navbar,
                .main-header .logo {
                    background-color: var(--cb) !important;
                    border-bottom: 3px solid var(--cr) !important;
                    color: var(--ct) !important;
                }
                .main-header .logo {
                    font-weight: 800 !important;
                    font-size: 18px !important;
                    letter-spacing: 2px !important;
                    color: var(--cr) !important;
                    border-right: 1px solid #333 !important;
                }
                .main-header .logo:hover { background-color: #111 !important; }
                .main-header .navbar .nav > li > a { color: #bbb !important; }
                .main-header .navbar .nav > li > a:hover { color: white !important; background-color: #222 !important; }
                .main-header .navbar .sidebar-toggle { color: #aaa !important; }
                .main-header .navbar .sidebar-toggle:hover { background-color: var(--cr) !important; color: white !important; }

                /* ── Sidebar ── */
                .main-sidebar,
                .left-side { background-color: var(--cb) !important; }
                .sidebar-menu > li > a { color: #bbb !important; }
                .sidebar-menu > li:hover > a,
                .sidebar-menu > li.active > a {
                    color: white !important;
                    background-color: var(--cr) !important;
                    border-left: 4px solid #ff4444 !important;
                }
                .sidebar-menu > li.header {
                    color: #555 !important;
                    background-color: transparent !important;
                    font-size: 11px !important;
                    letter-spacing: 1px !important;
                }

                /* ── Content area ── */
                .content-wrapper { background-color: #111 !important; }
                .content-header { border-bottom: 1px solid #2a2a2a !important; }
                .content-header h1 { color: var(--ct) !important; }
                .content-header h1 small { color: #888 !important; }

                /* ── Boxes / cards ── */
                .box {
                    background-color: var(--cs) !important;
                    border-top: 3px solid var(--cr) !important;
                    border: 1px solid #2a2a2a;
                }
                .box-header { background-color: var(--cm) !important; border-bottom: 1px solid #333 !important; }
                .box-header .box-title { color: var(--ct) !important; }
                .box-body { color: #ccc !important; }
                .box-footer { background-color: var(--cm) !important; border-top: 1px solid #333 !important; }

                /* ── Tables ── */
                .table { color: #ccc !important; }
                .table > thead > tr > th {
                    background-color: #0d0d0d !important;
                    color: var(--cr) !important;
                    border-bottom: 2px solid var(--cr) !important;
                    text-transform: uppercase;
                    font-size: 11px;
                    letter-spacing: 1px;
                }
                .table > tbody > tr > td { border-top: 1px solid #2a2a2a !important; }
                .table-hover > tbody > tr:hover { background-color: #1f0505 !important; }
                .table-striped > tbody > tr:nth-of-type(odd) { background-color: #161616 !important; }

                /* ── Forms ── */
                .form-control {
                    background-color: #111 !important;
                    border: 1px solid #333 !important;
                    color: #ddd !important;
                }
                .form-control:focus {
                    border-color: var(--cr) !important;
                    box-shadow: 0 0 0 2px rgba(204,0,0,0.2) !important;
                }
                label { color: #aaa !important; }
                .form-group .help-block { color: #666 !important; }

                /* ── Buttons ── */
                .btn-primary, .btn-success {
                    background-color: var(--cr) !important;
                    border-color: var(--cr-dark) !important;
                }
                .btn-primary:hover, .btn-success:hover {
                    background-color: var(--cr-dark) !important;
                }
                .btn-default {
                    background-color: #2a2a2a !important;
                    border-color: #444 !important;
                    color: #ccc !important;
                }

                /* ── Alerts ── */
                .alert-success { background-color: #0a1f0a !important; border-color: #1a4a1a !important; color: #6fcf6f !important; }
                .alert-danger  { background-color: #1f0505 !important; border-color: var(--cr-dark) !important; color: #ff8080 !important; }
                .alert-info    { background-color: #05101f !important; border-color: #1a3a5a !important; color: #80aaff !important; }
                .alert-warning { background-color: #1f1500 !important; border-color: #4a3800 !important; color: #ffd080 !important; }

                /* ── Pagination ── */
                .pagination > li > a { background-color: #1a1a1a !important; border-color: #333 !important; color: #ccc !important; }
                .pagination > .active > a { background-color: var(--cr) !important; border-color: var(--cr-dark) !important; }

                /* ── Footer ── */
                .main-footer {
                    background-color: var(--cb) !important;
                    border-top: 2px solid var(--cr) !important;
                    color: #555 !important;
                }

                /* ── Scrollbar ── */
                ::-webkit-scrollbar { width: 6px; }
                ::-webkit-scrollbar-track { background: #0d0d0d; }
                ::-webkit-scrollbar-thumb { background: var(--cr); border-radius: 4px; }

                /* ── Select2 ── */
                .select2-container--default .select2-selection--single,
                .select2-container--default .select2-selection--multiple {
                    background-color: #111 !important;
                    border-color: #333 !important;
                    color: #ddd !important;
                }
                .select2-dropdown { background-color: #1a1a1a !important; border-color: #333 !important; }
                .select2-container--default .select2-results__option--highlighted {
                    background-color: var(--cr) !important;
                }
            </style>

            <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->
        @show
    </head>
    <body class="hold-transition skin-blue fixed sidebar-mini">
        <div class="wrapper">
            <header class="main-header">
                <a href="{{ route('index') }}" class="logo">
                    <span>{{ config('app.name', 'Cardinals') }}</span>
                </a>
                <nav class="navbar navbar-static-top">
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="user-menu">
                                <a href="{{ route('account') }}">
                                    <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(Auth::user()->email)) }}?s=160" class="user-image" alt="User Image">
                                    <span class="hidden-xs">{{ Auth::user()->name_first }} {{ Auth::user()->name_last }}</span>
                                </a>
                            </li>
                            <li>
                                <li><a href="{{ route('index') }}" data-toggle="tooltip" data-placement="bottom" title="Exit Admin Control"><i class="fa fa-server"></i></a></li>
                            </li>
                            <li>
                                <li><a href="{{ route('auth.logout') }}" id="logoutButton" data-toggle="tooltip" data-placement="bottom" title="Logout"><i class="fa fa-sign-out"></i></a></li>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <aside class="main-sidebar">
                <section class="sidebar">
                    <ul class="sidebar-menu">
                        <li class="header">BASIC ADMINISTRATION</li>
                        <li class="{{ Route::currentRouteName() !== 'admin.index' ?: 'active' }}">
                            <a href="{{ route('admin.index') }}">
                                <i class="fa fa-home"></i> <span>Overview</span>
                            </a>
                        </li>
                        <li class="{{ ! starts_with(Route::currentRouteName(), 'admin.settings') ?: 'active' }}">
                            <a href="{{ route('admin.settings')}}">
                                <i class="fa fa-wrench"></i> <span>Settings</span>
                            </a>
                        </li>
                        <li class="{{ ! starts_with(Route::currentRouteName(), 'admin.api') ?: 'active' }}">
                            <a href="{{ route('admin.api.index')}}">
                                <i class="fa fa-gamepad"></i> <span>Application API</span>
                            </a>
                        </li>
                        <li class="header">MANAGEMENT</li>
                        <li class="{{ ! starts_with(Route::currentRouteName(), 'admin.databases') ?: 'active' }}">
                            <a href="{{ route('admin.databases') }}">
                                <i class="fa fa-database"></i> <span>Databases</span>
                            </a>
                        </li>
                        <li class="{{ ! starts_with(Route::currentRouteName(), 'admin.locations') ?: 'active' }}">
                            <a href="{{ route('admin.locations') }}">
                                <i class="fa fa-globe"></i> <span>Locations</span>
                            </a>
                        </li>
                        <li class="{{ ! starts_with(Route::currentRouteName(), 'admin.nodes') ?: 'active' }}">
                            <a href="{{ route('admin.nodes') }}">
                                <i class="fa fa-sitemap"></i> <span>Nodes</span>
                            </a>
                        </li>
                        <li class="{{ ! starts_with(Route::currentRouteName(), 'admin.servers') ?: 'active' }}">
                            <a href="{{ route('admin.servers') }}">
                                <i class="fa fa-server"></i> <span>Servers</span>
                            </a>
                        </li>
                        <li class="{{ ! starts_with(Route::currentRouteName(), 'admin.users') ?: 'active' }}">
                            <a href="{{ route('admin.users') }}">
                                <i class="fa fa-users"></i> <span>Users</span>
                            </a>
                        </li>
                        <li class="header">SERVICE MANAGEMENT</li>
                        <li class="{{ ! starts_with(Route::currentRouteName(), 'admin.mounts') ?: 'active' }}">
                            <a href="{{ route('admin.mounts') }}">
                                <i class="fa fa-magic"></i> <span>Mounts</span>
                            </a>
                        </li>
                        <li class="{{ ! starts_with(Route::currentRouteName(), 'admin.nests') ?: 'active' }}">
                            <a href="{{ route('admin.nests') }}">
                                <i class="fa fa-th-large"></i> <span>Nests</span>
                            </a>
                        </li>
                    </ul>
                </section>
            </aside>
            <div class="content-wrapper">
                <section class="content-header">
                    @yield('content-header')
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    There was an error validating the data provided.<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @foreach (Alert::getMessages() as $type => $messages)
                                @foreach ($messages as $message)
                                    <div class="alert alert-{{ $type }} alert-dismissable" role="alert">
                                        {{ $message }}
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                    @yield('content')
                </section>
            </div>
            <footer class="main-footer">
                <div class="pull-right small text-gray" style="margin-right:10px;margin-top:-7px;">
                    <strong><i class="fa fa-fw {{ $appIsGit ? 'fa-git-square' : 'fa-code-fork' }}"></i></strong> {{ $appVersion }}<br />
                    <strong><i class="fa fa-fw fa-clock-o"></i></strong> {{ round(microtime(true) - LARAVEL_START, 3) }}s
                </div>
                Copyright &copy; 2025 - {{ date('Y') }} Cardinals Panel.
            </footer>
        </div>
        @section('footer-scripts')
            <script src="/js/keyboard.polyfill.js" type="application/javascript"></script>
            <script>keyboardeventKeyPolyfill.polyfill();</script>

            {!! Theme::js('vendor/jquery/jquery.min.js?t={cache-version}') !!}
            {!! Theme::js('vendor/sweetalert/sweetalert.min.js?t={cache-version}') !!}
            {!! Theme::js('vendor/bootstrap/bootstrap.min.js?t={cache-version}') !!}
            {!! Theme::js('vendor/slimscroll/jquery.slimscroll.min.js?t={cache-version}') !!}
            {!! Theme::js('vendor/adminlte/app.min.js?t={cache-version}') !!}
            {!! Theme::js('vendor/bootstrap-notify/bootstrap-notify.min.js?t={cache-version}') !!}
            {!! Theme::js('vendor/select2/select2.full.min.js?t={cache-version}') !!}
            {!! Theme::js('js/admin/functions.js?t={cache-version}') !!}
            <script src="/js/autocomplete.js" type="application/javascript"></script>

            @if(Auth::user()->root_admin)
                <script>
                    $('#logoutButton').on('click', function (event) {
                        event.preventDefault();

                        var that = this;
                        swal({
                            title: 'Do you want to log out?',
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d9534f',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Log out'
                        }, function () {
                             $.ajax({
                                type: 'POST',
                                url: '{{ route('auth.logout') }}',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },complete: function () {
                                    window.location.href = '{{route('auth.login')}}';
                                }
                        });
                    });
                });
                </script>
            @endif

            <script>
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip();
                })
            </script>
        @show
    </body>
</html>
