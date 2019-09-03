@extends('admin.layouts.master')

@section('head.css')
    <link href="{{asset('/css/admin/plugins/daterangepicker.css')}}" rel="stylesheet">
    <style>
        /*table.dataTable{*/
        /*    width: auto;*/
        /*}*/
        /*table.dataTable th{*/
        /*    text-align: center;*/
        /*}*/
        /*table.dataTable th, table.dataTable td{*/
        /*    padding: 3px;*/
        /*    vertical-align: middle !important;*/
        /*}*/
    </style>
@endsection

@section('body.js')
    <script src="{{asset('js/admin/plugins/moment.min.js') }}" type='text/javascript'></script>
    <script src="{{asset('js/admin/plugins/daterangepicker.min.js') }}" type='text/javascript'></script>
    <script src="{{asset('js/admin/date-picker.js') }}" type='text/javascript'></script>
@endsection

@section('body.content')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-edit"></i> Danh Sách Nguyên Liệu
            <a class="btn btn-sm btn-primary pull-right" href="{{route('admin.material.create')}}" >Thêm Nguyên Liệu</a>
        </div>
        <div class="card-body">
            <table class="table dataTable table-responsive-sm table-bordered table-striped table-sm">
                <thead>
                <tr>
                    <th width="50">Mã</th>
                    <th width="150">Tên Nguyên Liệu</th>
                    <th width="120">Loại Nguyên Liệu</th>
                    <th width="150">Đơn Vị</th>
                    <th width="120">Đon Giá</th>
                    <th width="120">Nhà Cung Cấp</th>
                    <th width="120"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($materials as $index => $material)
                    <tr>
                        <td>{{$index + 1}}</td>
                        <td>{{$material->material_name}}</td>
                        <td>{{$material->material_type->material_type_name}}</td>
                        <td>{{$material->unit->unit_name}}</td>
                        <td>{{ \App\Helpers\AppHelper::formatMoney($material->pirce)}}</td>
                        <td class="text-center">
                            <a class="btn btn-info" href="{{route('admin.material.update',['id' => $material->id])}}">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a data-toggle="modal" class="btn btn-danger anchorClick"
                               data-url="{{route('admin.material.delete',['id' => $material->id]) }}"
                               data-name="{{$material->material_name}}" href="#deleteModal">
                                <i class="fa fa-trash-o"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
