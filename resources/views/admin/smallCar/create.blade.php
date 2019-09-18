@extends('admin.layouts.master')

@section('body.content')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-edit"></i>Tạo Mới Xe Nhỏ
            <a class="btn btn-sm btn-dark pull-right" href="{{route('admin.setting.small_car')}}" >Quay Lại</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="car_name">Tên Xe Nhỏ</label>
                        <input class="form-control" id="car_name" name="car_name" type="text" placeholder="Tên xe nhỏ" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Địa Chỉ Email</label>
                        <input class="form-control" id="email" name="email" type="text" placeholder="Địa chỉ email">
                    </div>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div>
    </div>
@endsection
