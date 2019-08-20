@extends('admin.layouts.master')

@section('body.content')
    <div class="card">
        <div class="card-header">
            <strong>Nhập Thông Tin Nhân Viên</strong>
        </div>
        <form action="{{route('admin.employee.update',['id' => $employee->id])}}" method="post">
            @csrf
            <div class="card-body">

                <div class="form-group">
                    <label for="name">Tên Nhân Viên</label>
                    <input class="form-control" id="name" name="name" type="text" placeholder="Tên nhân viên" value="{{$employee->name}}" required>
                </div>
                <div class="form-group">
                    <label for="phone">Số Điện Thoại</label>
                    <input class="form-control" id="phone" name="phone" type="text" placeholder="Số điện thoại" value="{{$employee->phone}}">
                </div>
                <div class="form-group">
                    <label for="email">Địa Chỉ Email</label>
                    <input class="form-control" id="email" name="email" type="text" placeholder="Địa chỉ email" value="{{$employee->email}}">
                </div>
                <div class="form-group">
                    <label for="identity_card">Số Chứng Minh Nhân Dân</label>
                    <input class="form-control" id="identity_card" name="identity_card" type="text" placeholder="Số CMND" value="{{$employee->identity_card}}">
                </div>
            </div>
            <div class="card-footer text-center">
                <button class="btn btn-sm btn-primary" type="submit">
                    <i class="fa fa-dot-circle-o"></i> Cập Nhật</button>
            </div>
        </form>
    </div>
@endsection
