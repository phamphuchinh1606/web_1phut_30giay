@extends('admin.layouts.master')

@section('body.content')
    <div class="card">
        <div class="card-header">
            <strong>Nhập Thông Tin Nhân Viên</strong>

            <a class="btn btn-sm btn-secondary pull-right" href="{{route('admin.employee')}}" >Quay lại</a>
        </div>
        <form action="{{route('admin.employee.create')}}" method="post">
            @csrf
            <input type="hidden" value="{{$branchId}}" name="branch_id">
            <div class="card-body">

                <div class="form-group">
                    <label for="name">Tên Nhân Viên</label>
                    <input class="form-control" id="name" name="name" type="text" placeholder="Tên nhân viên" required>
                </div>
                <div class="form-group">
                    <label for="phone">Số Điện Thoại</label>
                    <input class="form-control" id="phone" name="phone" type="text" placeholder="Số điện thoại">
                </div>
                <div class="form-group">
                    <label for="email">Địa Chỉ Email</label>
                    <input class="form-control" id="email" name="email" type="text" placeholder="Địa chỉ email">
                </div>
                <div class="form-group">
                    <label for="identity_card">Số Chứng Minh Nhân Dân</label>
                    <input class="form-control" id="identity_card" name="identity_card" type="text" placeholder="Số CMND">
                </div>
            </div>
            <div class="card-footer text-center">
                <button class="btn btn-sm btn-primary" type="submit">
                    <i class="fa fa-dot-circle-o"></i> Thêm Mới Nhân Viên</button>
            </div>
        </form>
    </div>
@endsection
