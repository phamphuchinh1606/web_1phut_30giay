
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

    <link href="{{asset('css/admin/plugins/coreui-icons.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/admin/plugins/flag-icon.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/admin/plugins/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/admin/plugins/simple-line-icons.css')}}" rel="stylesheet">

    <link href="{{asset('css/admin/plugins/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/admin/plugins/pace.min.css')}}" rel="stylesheet">
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
        <div class="col-md-10">
            <div class="card-group">
                <div class="card p-4">
                    <form method="POST" action="{{ route('admin.login') }}">
                        @csrf
                        <div class="card-body">
                            <h1>Login</h1>
                            <p class="text-muted">Login với tài khoản của bạn</p>
                            <div class="input-group mb-3">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            <p>{{ $error }}</p>
                                        @endforeach
                                    </div>
                                @endif
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="icon-user"></i>
                                    </span>
                                </div>
                                <input name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" placeholder="Tên tài khoản" value="{{ old('email') }}" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="icon-lock"></i>
                                </span>
                                </div>
                                <input name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" placeholder="Mật khẩu" required>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <button class="btn btn-primary px-4" type="submit">Đăng Nhập</button>
                                </div>
                                <div class="col-6 text-right">
                                    <button class="btn btn-link px-0" type="button">Quên mật khẩu?</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
                    <div class="card-body text-center">
                        <div>
                            <h2>Đăng ký</h2>
                            <p>Đăng ký thông tin tài khoản đăng nhập . Tài khoản khi tạo sẽ là tài khoản khách hàng. Tài khoản Admin thì liên hệ với bộ phận kỹ thuật.</p>
                            <button class="btn btn-primary active mt-3" type="button">Đăng ký ngay!</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
