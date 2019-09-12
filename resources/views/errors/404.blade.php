
<!DOCTYPE html>

<html lang="en">
<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title>CoreUI Pro Bootstrap Admin Template</title>

    <link href="{{\App\Helpers\AppHelper::assetPublic('css/admin/plugins/coreui-icons.min.css')}}" rel="stylesheet">
    <link href="{{\App\Helpers\AppHelper::assetPublic('css/admin/plugins/flag-icon.min.css')}}" rel="stylesheet">
    <link href="{{\App\Helpers\AppHelper::assetPublic('css/admin/plugins/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{\App\Helpers\AppHelper::assetPublic('css/admin/plugins/simple-line-icons.css')}}" rel="stylesheet">

    <link href="{{\App\Helpers\AppHelper::assetPublic('css/admin/plugins/style.css')}}" rel="stylesheet">
    <link href="{{\App\Helpers\AppHelper::assetPublic('css/admin/plugins/pace.min.css')}}" rel="stylesheet">
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
<body class="app flex-row align-items-center">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="clearfix">
                <h1 class="float-left display-3 mr-4">404</h1>
                <h4 class="pt-3">Xin lỗi bạn.</h4>
                <p class="text-muted">Trang bạn đang tìm kiếm hiện không tồn tại.</p>
                <p class="text-muted">
                    Vui lòng click <a href="{{route('home')}}">"vào đây"</a> để trở lại trang chủ.
                </p>
            </div>
        </div>
    </div>
</div>

<script src="{{\App\Helpers\AppHelper::assetPublic('js/admin/plugins/jquery.min.js')}}"></script>
<script src="{{\App\Helpers\AppHelper::assetPublic('js/admin/plugins/popper.min.js')}}"></script>
<script src="{{\App\Helpers\AppHelper::assetPublic('js/admin/plugins/bootstrap.min.js')}}"></script>
<script src="{{\App\Helpers\AppHelper::assetPublic('js/admin/plugins/pace.min.js')}}"></script>
<script src="{{\App\Helpers\AppHelper::assetPublic('js/admin/plugins/perfect-scrollbar.min.js')}}"></script>
<script src="{{\App\Helpers\AppHelper::assetPublic('js/admin/plugins/coreui.min.js')}}"></script>
<script>
    $('#ui-view').ajaxLoad();
    $(document).ajaxComplete(function() {
        Pace.restart()
    });
</script>
</body>
</html>
