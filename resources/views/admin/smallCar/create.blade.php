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
                    <div class="card">
                        <div class="card-header">
                            Thiết Lặp Số Lượng Sản Phẩm
                        </div>
                        <div class="card-body">
                            <table class="table table-responsive-sm table-bordered table-sm">
                                <thead>
                                    <tr class="text-center">
                                        <th rowspan="2">Tên Sản Phẩm</th>
                                        <th colspan="2">Rau</th>
                                        <th rowspan="2">Tổng</th>
                                    </tr>
                                    <tr class="text-center">
                                        <th>Có</th>
                                        <th>Không</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td>{{$product->product_short_name}}</td>
                                            <td>
                                                <input class="form-control" name="qty_have_vegetables_{{$product->id}}"/>
                                            </td>
                                            <td>
                                                <input class="form-control" name="qty_no_vegetables_{{$product->id}}"/>
                                            </td>
                                            <td>
                                                <span>{{$product->total_qty}}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
