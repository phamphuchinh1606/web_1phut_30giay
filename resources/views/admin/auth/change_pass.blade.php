@extends('admin.layouts.master')

@section('head.title','Thay đổi mật khẩu')

@section('body.content')
    <div class="card">
        <div class="card-header">
            <strong>Thay đổi mật khẩu</strong>
        </div>
        <form class="form-horizontal" action="{{route('admin.update_pass')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card-body">
                            @if(isset($info))
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <div class="alert alert-success" role="alert">{{ $info }}</div>
                                    </div>
                                </div>
                            @endif
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="password_old">Mật khẩu cũ</label>
                                <div class="col-md-9">
                                    <input class="form-control" id="password_old" type="password" name="password_old" placeholder="Mật khẩu cũ" required>
                                    @if ($errors->has('password_old'))
                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('password_old') }}</strong>
                                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="password">Mật khẩu mới</label>
                                <div class="col-md-9">
                                    <input class="form-control" id="password" type="password" name="password" placeholder="Mật khẩu mới" required>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="password_confirmation">Nhập lại mật khẩu</label>
                                <div class="col-md-9">
                                    <input class="form-control" id="password_confirmation" type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu" required>
                                    @if ($errors->has('password_confirmation'))
                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <button class="btn btn-sm btn-primary" type="submit">
                    <i class="fa fa-dot-circle-o"></i>Cập Nhật</button>
            </div>
        </form>
    </div>
@endsection
