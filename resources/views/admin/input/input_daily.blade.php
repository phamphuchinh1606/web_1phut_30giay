@extends('admin.layouts.master')

@section('body.content')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-edit"></i> Số Lượng Bán Ngày : 2019/11/21
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered datatable dataTable no-footer" id="DataTables_Table_0"
                   role="grid" aria-describedby="DataTables_Table_0_info" style="border-collapse: collapse !important">
                <thead>
                <tr role="row">
                    <th rowspan="2" class="text-center">Mã Sản Phẩm</th>
                    <th rowspan="2" class="text-center">Tên Sản Phẩm</th>
                    <th rowspan="2" class="text-center">Đơn Vị</th>
                    <th rowspan="2" class="text-center">Đơn Giá</th>
                    <th rowspan="2" class="text-center">Tồn Đầu</th>
                    <th rowspan="2" class="text-center">Nhập</th>
                    <th rowspan="2" class="text-center">Thành Tiền</th>
                    <th rowspan="2" class="text-center">Nhập Chuyển</th>
                    <th colspan="2" class="text-center">Xuất</th>
                    <th rowspan="2" class="text-center">Tồn Cuối</th>
                </tr>
                <tr>
                    <th class="text-center">Xuất</th>
                    <th class="text-center">Hủy</th>
                </tr>
                </thead>
                <tbody>
                @foreach($materialTypes as $materialType)
                    <tr role="row" style="background-color: yellowgreen">
                        <td colspan="11"></td>
                    </tr>
                    @if(isset($materialType->materials))
                        @foreach($materialType->materials as $material)
                            <tr role="row">
                                <td>{{$material->id}}</td>
                                <td>{{$material->material_name}}</td>
                                <td>{{$material->unit['unit_name']}}</td>
                                <td>{{$material->price}}</td>
                            </tr>
                        @endforeach
                    @endif
                @endforeach


                <tr role="row" class="odd">
                    <td class="sorting_1">Adam Alister</td>
                    <td>2012/01/21</td>
                    <td>Staff</td>
                    <td>
                        <span class="badge badge-success">Active</span>
                    </td>
                    <td>
                        <a class="btn btn-success" href="#">
                            <i class="fa fa-search-plus"></i>
                        </a>
                        <a class="btn btn-info" href="#">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a class="btn btn-danger" href="#">
                            <i class="fa fa-trash-o"></i>
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
