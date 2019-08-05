<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <link id="favicon" rel="shortcut icon" href="{{\App\Helpers\ImageHelper::showImage($appInfo->app_src_icon)}}" type="image/x-icon" />
    <!-- CSRF Token -->
    <meta name="_token" content="{{ csrf_token() }}">
    <title>@yield('head.title','Quan ly thang may')</title>

    <link href="{{\App\Helpers\AppHelper::assetPublic('css/admin/plugins/coreui-icons.min.css')}}" rel="stylesheet">
    <link href="{{\App\Helpers\AppHelper::assetPublic('css/admin/plugins/flag-icon.min.css')}}" rel="stylesheet">
    <link href="{{\App\Helpers\AppHelper::assetPublic('css/admin/plugins/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{\App\Helpers\AppHelper::assetPublic('css/admin/plugins/simple-line-icons.css')}}" rel="stylesheet">

    <link href="{{\App\Helpers\AppHelper::assetPublic('css/admin/plugins/style.css')}}" rel="stylesheet">
    <link href="{{\App\Helpers\AppHelper::assetPublic('css/admin/plugins/pace.min.css')}}" rel="stylesheet">
    <link href="{{\App\Helpers\AppHelper::assetPublic('css/admin/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <script src="{{\App\Helpers\AppHelper::assetPublic('js/admin/plugins/jquery.min.js')}}"></script>
    @yield('head.css')
    <script>
        (function(i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function() {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o), m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
        ga('create', 'UA-118965717-1', 'auto');
        ga('send', 'pageview');
    </script>
</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed pace-done sidebar-lg-show">
    <div class="pace  pace-inactive">
        <div class="pace-progress" data-progress-text="100%" data-progress="99" style="transform: translate3d(100%, 0px, 0px);">
            <div class="pace-progress-inner"></div>
        </div>
        <div class="pace-activity"></div>
    </div>

    {{--Header--}}
    @include('admin.layouts.partials.__header')

    {{--App Body--}}
    <div class="app-body">
        {{--Sidebar--}}
        @include('admin.layouts.partials.__sidebar')

        {{--Main--}}
        <div class="main">
            {{--@include('admin.common.__breadcrumb')--}}
            @yield('body.breadcrumb')
            @yield('body.content')
        </div>

        {{--Aside Menu--}}
        @include('admin.layouts.partials.__aside_menu')
    </div>

    {{--Footer--}}
    @include('admin.layouts.partials.__footer')


    <script src="{{\App\Helpers\AppHelper::assetPublic('js/admin/plugins/popper.min.js')}}"></script>
    <script src="{{\App\Helpers\AppHelper::assetPublic('js/admin/plugins/bootstrap.min.js')}}"></script>
    <script src="{{\App\Helpers\AppHelper::assetPublic('js/admin/plugins/pace.min.js')}}"></script>
    <script src="{{\App\Helpers\AppHelper::assetPublic('js/admin/plugins/perfect-scrollbar.min.js')}}"></script>
    <script src="{{\App\Helpers\AppHelper::assetPublic('js/admin/plugins/coreui.min.js')}}"></script>
    <script src="{{\App\Helpers\AppHelper::assetPublic('js/admin/form.input.number.js') }}" type='text/javascript'></script>
    <script src="{{\App\Helpers\AppHelper::assetPublic('js/admin/plugins/tooltips.js') }}" type='text/javascript'></script>
    @yield('body.js')
    <script>
        // $('#ui-view').ajaxLoad();
        // $(document).ajaxComplete(function() {
        //     Pace.restart()
        // });
    </script>
    @include('admin.common.__popup_confirm_delete')
    @yield('body.popup')
</body>
</html>
